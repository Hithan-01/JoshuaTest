<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

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
            
            // Debug opcional solo en modo desarrollo
            if (Configure::read('debug')) {
                $email = $this->request->getData('email');
                $password = $this->request->getData('password');
                $user = $this->Users->find()->where(['email' => $email])->first();
                
                if ($user) {
                    $this->Flash->error("Debug: Usuario encontrado. Password en DB: '{$user->password}', Password enviado: '{$password}'");
                } else {
                    $this->Flash->error("Debug: Usuario no encontrado para email: {$email}");
                }
            }
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
                'password' => '1234',  // Texto plano
                'role' => 'admin',
                'active' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'estudiante@gmail.com', 
                'password' => '1234',  // Texto plano
                'role' => 'estudiante',
                'active' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'admin@test.com',
                'password' => '1234',  // Texto plano
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
}