<?php
declare(strict_types=1);

namespace App\Controller;

class ExamenesController extends AppController
{
    public function index()
    {
        $query = $this->Examenes->find()
            ->contain(['Users']);
        $examenes = $this->paginate($query);

        $this->set(compact('examenes'));
    }

    public function view($id = null)
    {
        $examene = $this->Examenes->get($id, contain: ['Users', 'Reactivos']);
        $this->set(compact('examene'));
    }

    // 🔹 Página principal para estudiantes - Lista de exámenes disponibles
    public function disponibles()
    {
        // Solo usuarios autenticados pueden acceder
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // Solo estudiantes pueden acceder a esta vista
        if ($identity->get('role') !== 'estudiante') {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección.'));
            return $this->redirect(['action' => 'index']);
        }

        // Obtener todos los exámenes disponibles
        $examenes = $this->Examenes->find('all')->contain(['Users']);
        $this->set(compact('examenes'));
    }

    // 🔹 Tomar un examen específico (para estudiantes)
    public function tomar($id = null)
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity || $identity->get('role') !== 'estudiante') {
            $this->Flash->error(__('No tienes permisos para tomar exámenes.'));
            return $this->redirect(['action' => 'disponibles']);
        }

        try {
            // Obtener el examen con sus reactivos
            $examen = $this->Examenes->get($id, [
                'contain' => ['Reactivos']
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('El examen no existe.'));
            return $this->redirect(['action' => 'disponibles']);
        }

        // Procesar respuestas si es POST
        if ($this->request->is('post')) {
            $respuestasTable = $this->fetchTable('Respuestas');
            $respuestasData = $this->request->getData('respuestas');
            
            if (!empty($respuestasData)) {
                foreach ($respuestasData as $reactivoId => $respuestaUsuario) {
                    $respuesta = $respuestasTable->newEmptyEntity();
                    $respuesta->examen_id = $examen->id;
                    $respuesta->reactivo_id = $reactivoId;
                    $respuesta->user_id = $identity->id;
                    $respuesta->respuesta_usuario = $respuestaUsuario;

                    $respuestasTable->save($respuesta);
                }
                $this->Flash->success(__('Examen enviado correctamente!'));
            } else {
                $this->Flash->error(__('Debes responder al menos una pregunta.'));
            }
            
            return $this->redirect(['action' => 'disponibles']);
        }

        $this->set(compact('examen'));
    }

    // 🔹 Generar examen aleatorio para el usuario actual
    public function generar()
    {
        $user = $this->Authentication->getIdentity();

        $examene = $this->Examenes->newEntity([
            'titulo' => 'Examen generado',
            'descripcion' => 'Examen automático con reactivos aleatorios',
            'user_id' => $user->id
        ]);

        if ($this->Examenes->save($examene)) {
            // Tomamos 5 reactivos aleatorios
            $reactivos = $this->fetchTable('Reactivos')
                ->find()
                ->order('RANDOM()')
                ->limit(5)
                ->all();

            // Asociamos los reactivos al examen
            $this->Examenes->Reactivos->link($examene, $reactivos);

            $this->Flash->success('Examen generado correctamente.');
            return $this->redirect(['action' => 'responder', $examene->id]);
        }

        $this->Flash->error('No se pudo generar el examen.');
        return $this->redirect(['action' => 'index']);
    }

    public function responder($id = null)
    {
        // 1. Obtener examen
        $examen = $this->Examenes->get($id, ['contain' => ['Reactivos']]);

        // 2. Obtener usuario autenticado
        $user = $this->request->getAttribute('identity');

        if ($this->request->is(['post', 'put'])) {
            $respuestasTable = $this->fetchTable('Respuestas');
            
            foreach ($this->request->getData('respuestas') as $reactivoId => $respuestaUsuario) {
                $respuesta = $respuestasTable->newEmptyEntity();
                $respuesta->examen_id = $examen->id;
                $respuesta->reactivo_id = $reactivoId;
                $respuesta->user_id = $user->id;
                $respuesta->respuesta_usuario = $respuestaUsuario;

                $respuestasTable->save($respuesta);
            }

            $this->Flash->success(__('Tus respuestas fueron guardadas.'));
            return $this->redirect(['action' => 'view', $examen->id]);
        }

        // Renderizar examen con preguntas
        $this->set(compact('examen'));
    }

    // 🔹 Ver resultado de un examen (opcional)
    public function resultado($id = null)
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity || $identity->get('role') !== 'estudiante') {
            $this->Flash->error(__('No tienes permisos para ver resultados.'));
            return $this->redirect(['action' => 'disponibles']);
        }

        // Obtener el examen y las respuestas del estudiante
        $examen = $this->Examenes->get($id, [
            'contain' => ['Reactivos']
        ]);

        // Obtener las respuestas del estudiante para este examen
        $respuestasTable = $this->fetchTable('Respuestas');
        $respuestas = $respuestasTable->find()
            ->where([
                'examen_id' => $id,
                'user_id' => $identity->id
            ])
            ->all();

        $this->set(compact('examen', 'respuestas'));
    }
}