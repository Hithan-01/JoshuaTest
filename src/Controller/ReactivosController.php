<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reactivos Controller
 *
 * @property \App\Model\Table\ReactivosTable $Reactivos
 */
class ReactivosController extends AppController
{



    public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);

    $this->Authentication->allowUnauthenticated(['index', 'view', 'login']); 

    $identity = $this->Authentication->getIdentity();

    // Si no está logueado → redirige al login
    if (!$identity) {
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    // Si no es admin → bloquear add, edit, delete
    if (in_array($this->request->getParam('action'), ['add', 'edit', 'delete']) &&
        $identity->get('role') !== 'admin') {
        $this->Flash->error('Solo los administradores pueden modificar reactivos.');
        return $this->redirect(['action' => 'index']);
    }
}



    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Reactivos->find()
            ->contain(['Users']);
        $reactivos = $this->paginate($query);

        $this->set(compact('reactivos'));
    }

    /**
     * View method
     *
     * @param string|null $id Reactivo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reactivo = $this->Reactivos->get($id, contain: ['Users']);
        $this->set(compact('reactivo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reactivo = $this->Reactivos->newEmptyEntity();
        if ($this->request->is('post')) {
            $reactivo = $this->Reactivos->patchEntity($reactivo, $this->request->getData());
            if ($this->Reactivos->save($reactivo)) {
                $this->Flash->success(__('The reactivo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reactivo could not be saved. Please, try again.'));
        }
        $users = $this->Reactivos->Users->find('list', limit: 200)->all();
        $this->set(compact('reactivo', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reactivo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reactivo = $this->Reactivos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reactivo = $this->Reactivos->patchEntity($reactivo, $this->request->getData());
            if ($this->Reactivos->save($reactivo)) {
                $this->Flash->success(__('The reactivo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reactivo could not be saved. Please, try again.'));
        }
        $users = $this->Reactivos->Users->find('list', limit: 200)->all();
        $this->set(compact('reactivo', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reactivo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reactivo = $this->Reactivos->get($id);
        if ($this->Reactivos->delete($reactivo)) {
            $this->Flash->success(__('The reactivo has been deleted.'));
        } else {
            $this->Flash->error(__('The reactivo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
