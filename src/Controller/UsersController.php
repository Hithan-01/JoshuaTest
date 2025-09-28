<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

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
}
