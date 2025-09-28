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

    // MÉTODO TEMPORAL PARA CREAR USUARIO DE PRUEBA
    public function createTestUser()
    {
        // Eliminar usuario de prueba si existe
        $existingUser = $this->Users->find()
            ->where(['email' => 'test@test.com'])
            ->first();
        
        if ($existingUser) {
            $this->Users->delete($existingUser);
            echo '<p>Usuario anterior eliminado.</p>';
        }
        
        // Crear nuevo usuario de prueba
        $user = $this->Users->newEntity([
            'email' => 'test@test.com',
            'password' => '123456',  // Se hasheará automáticamente
            'role' => 'admin',
            'active' => true
        ]);
        
        if ($this->Users->save($user)) {
            echo '<h2 style="color: green;">✅ Usuario de prueba creado exitosamente!</h2>';
            echo '<div style="background: #f0f8f0; padding: 20px; border: 1px solid #4CAF50; margin: 20px 0;">';
            echo '<p><strong>Email:</strong> test@test.com</p>';
            echo '<p><strong>Password:</strong> 123456</p>';
            echo '<p><strong>Role:</strong> admin</p>';
            echo '<p><strong>Active:</strong> true</p>';
            echo '</div>';
            echo '<p><a href="' . $this->Url->build(['action' => 'login']) . '" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">🔑 Ir al Login</a></p>';
            
            // Verificar que se guardó correctamente
            $savedUser = $this->Users->find()->where(['email' => 'test@test.com'])->first();
            echo '<hr>';
            echo '<h3>Verificación en Base de Datos:</h3>';
            echo '<p><strong>ID:</strong> ' . $savedUser->id . '</p>';
            echo '<p><strong>Email:</strong> ' . $savedUser->email . '</p>';
            echo '<p><strong>Password Hash:</strong> ' . substr($savedUser->password, 0, 30) . '...</p>';
            echo '<p><strong>Role:</strong> ' . $savedUser->role . '</p>';
            echo '<p><strong>Active:</strong> ' . ($savedUser->active ? 'true' : 'false') . '</p>';
            
        } else {
            echo '<h2 style="color: red;">❌ Error al crear usuario:</h2>';
            echo '<pre>';
            debug($user->getErrors());
            echo '</pre>';
        }
        
        exit; // Para que no ejecute la vista
    }
}