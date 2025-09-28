<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Exception;
class UsersController extends AppController
{
    public function index()
    {
        $users = $this->paginate($this->Users->find());
        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario registrado correctamente.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('No se pudo registrar el usuario, intenta nuevamente.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario actualizado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar el usuario.'));
        }
        $this->set(compact('user'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Usuario eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el usuario.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $identity = $this->Authentication->getIdentity();

            // Redirección según el rol
            if ($identity->get('role') === 'admin') {
                $this->Flash->success(__('Bienvenido Administrador!'));
                return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
            } elseif ($identity->get('role') === 'estudiante') {
                $this->Flash->success(__('Bienvenido Estudiante!'));
                return $this->redirect(['controller' => 'Examenes', 'action' => 'disponibles']);
            } else {
                $this->Flash->success(__('Bienvenido Usuario!'));
                return $this->redirect(['controller' => 'Examenes', 'action' => 'index']);
            }
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Usuario o contraseña incorrectos.'));
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        $this->Flash->success(__('Has cerrado sesión.'));
        return $this->redirect(['action' => 'login']);
    }

    // MÉTODO TEMPORAL PARA CREAR USUARIOS DE PRUEBA CON CONTRASEÑAS EN TEXTO PLANO
    public function createPlainUsers()
    {
        // Limpiar usuarios existentes
        $this->Users->deleteAll([]);
        
        // Crear usuarios con contraseñas en texto plano
        $users = [
            [
                'email' => 'admin@example.com',
                'password' => '1234',
                'role' => 'admin',
                'active' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'estudiante@gmail.com', 
                'password' => '1234',
                'role' => 'estudiante',
                'active' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'admin@test.com',
                'password' => '1234',
                'role' => 'admin',
                'active' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ];
        
        $success = 0;
        foreach ($users as $userData) {
            $query = $this->Users->query();
            $result = $query->insert([
                'email', 'password', 'role', 'active', 'created', 'modified'
            ])
            ->values($userData)
            ->execute();
            
            if ($result) {
                $success++;
            }
        }
        
        echo '<div style="background: #d4edda; padding: 20px; border: 1px solid #c3e6cb; margin: 20px 0;">';
        echo '<h2>Usuarios creados con contraseñas en texto plano!</h2>';
        echo '<p><strong>Usuarios creados:</strong> ' . $success . '/3</p>';
        echo '</div>';
        
        echo '<div style="background: #fff3cd; padding: 20px; border: 1px solid #ffeaa7; margin: 20px 0;">';
        echo '<h3>Credenciales de prueba:</h3>';
        echo '<p><strong>Admin 1:</strong> admin@example.com / 1234</p>';
        echo '<p><strong>Admin 2:</strong> admin@test.com / 1234</p>';
        echo '<p><strong>Estudiante:</strong> estudiante@gmail.com / 1234</p>';
        echo '<p><em>Todas las contraseñas son: <strong>1234</strong></em></p>';
        echo '</div>';
        
        // Verificar en base de datos
        $allUsers = $this->Users->find()->all();
        echo '<div style="background: #f8f9fa; padding: 20px; border: 1px solid #ddd; margin: 20px 0;">';
        echo '<h3>Usuarios en Base de Datos:</h3>';
        foreach ($allUsers as $user) {
            echo '<p><strong>' . $user->email . '</strong> | Password: "' . $user->password . '" | Role: ' . $user->role . ' | Active: ' . ($user->active ? 'true' : 'false') . '</p>';
        }
        echo '</div>';
        
        echo '<p><a href="' . $this->Url->build(['action' => 'login']) . '" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Probar Login</a></p>';
        
        exit;
    }

    // MÉTODO TEMPORAL PARA VER EXÁMENES Y REACTIVOS
    public function debugExamenes()
    {
        echo '<h2>Debug de Exámenes y Reactivos</h2>';
        
        // Verificar exámenes
        $examenesTable = $this->fetchTable('Examenes');
        $examenes = $examenesTable->find()->all();
        
        echo '<h3>Exámenes (' . $examenes->count() . '):</h3>';
        echo '<table border="1" style="border-collapse: collapse; width: 100%;">';
        echo '<tr><th>ID</th><th>Título</th><th>Descripción</th><th>User ID</th></tr>';
        
        foreach ($examenes as $examen) {
            echo '<tr>';
            echo '<td>' . $examen->id . '</td>';
            echo '<td>' . ($examen->titulo ?? 'N/A') . '</td>';
            echo '<td>' . ($examen->descripcion ?? 'N/A') . '</td>';
            echo '<td>' . ($examen->user_id ?? 'N/A') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        
        // Verificar reactivos
        try {
            $reactivosTable = $this->fetchTable('Reactivos');
            $reactivos = $reactivosTable->find()->all();
            
            echo '<h3>Reactivos (' . $reactivos->count() . '):</h3>';
            echo '<table border="1" style="border-collapse: collapse; width: 100%;">';
            echo '<tr><th>ID</th><th>Pregunta</th><th>Tipo</th></tr>';
            
            foreach ($reactivos as $reactivo) {
                echo '<tr>';
                echo '<td>' . $reactivo->id . '</td>';
                echo '<td>' . (substr($reactivo->pregunta ?? 'N/A', 0, 50)) . '...</td>';
                echo '<td>' . ($reactivo->tipo ?? 'N/A') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } catch (Exception $e) {
            echo '<p><strong>Error al cargar reactivos:</strong> ' . $e->getMessage() . '</p>';
        }
        
        // Verificar tabla pivot directamente
        try {
            $connection = $examenesTable->getConnection();
            $query = $connection->execute("SELECT * FROM examenes_reactivos ORDER BY examen_id, reactivo_id");
            $relaciones = $query->fetchAll();
            
            echo '<h3>Relaciones Examenes-Reactivos:</h3>';
            echo '<table border="1" style="border-collapse: collapse; width: 100%;">';
            echo '<tr><th>ID</th><th>Examen ID</th><th>Reactivo ID</th></tr>';
            
            foreach ($relaciones as $relacion) {
                echo '<tr>';
                echo '<td>' . $relacion[0] . '</td>';
                echo '<td>' . $relacion[1] . '</td>';
                echo '<td>' . $relacion[2] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            
        } catch (Exception $e) {
            echo '<p><strong>Error al listar relaciones:</strong> ' . $e->getMessage() . '</p>';
        }
        
        // Probar cargar un examen específico con reactivos
        echo '<h3>Test de carga de relaciones:</h3>';
        try {
            $examenConReactivos = $examenesTable->get(1, ['contain' => ['Reactivos']]);
            echo '<p><strong>Examen ID 1 con contain:</strong> ' . count($examenConReactivos->reactivos) . ' reactivos cargados</p>';
            
            if (!empty($examenConReactivos->reactivos)) {
                echo '<ul>';
                foreach ($examenConReactivos->reactivos as $reactivo) {
                    echo '<li>Reactivo ID: ' . $reactivo->id . ' - ' . substr($reactivo->pregunta, 0, 50) . '...</li>';
                }
                echo '</ul>';
            }
        } catch (Exception $e) {
            echo '<p><strong>Error al cargar examen con reactivos:</strong> ' . $e->getMessage() . '</p>';
        }
        
        echo '<hr>';
        echo '<p><a href="' . $this->Url->build(['controller' => 'Examenes', 'action' => 'disponibles']) . '">Volver a Exámenes</a></p>';
        
        exit;
    }
}