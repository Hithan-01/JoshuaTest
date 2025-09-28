<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ExamenesReactivos Controller
 *
 * @property \App\Model\Table\ExamenesReactivosTable $ExamenesReactivos
 */
class ExamenesReactivosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ExamenesReactivos->find()
            ->contain(['Reactivos']);
        $examenesReactivos = $this->paginate($query);

        $this->set(compact('examenesReactivos'));
    }

    /**
     * View method
     *
     * @param string|null $id Examenes Reactivo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $examenesReactivo = $this->ExamenesReactivos->get($id, contain: ['Reactivos']);
        $this->set(compact('examenesReactivo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $examenesReactivo = $this->ExamenesReactivos->newEmptyEntity();
        if ($this->request->is('post')) {
            $examenesReactivo = $this->ExamenesReactivos->patchEntity($examenesReactivo, $this->request->getData());
            if ($this->ExamenesReactivos->save($examenesReactivo)) {
                $this->Flash->success(__('The examenes reactivo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The examenes reactivo could not be saved. Please, try again.'));
        }
        $reactivos = $this->ExamenesReactivos->Reactivos->find('list', limit: 200)->all();
        $this->set(compact('examenesReactivo', 'reactivos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Examenes Reactivo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $examenesReactivo = $this->ExamenesReactivos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $examenesReactivo = $this->ExamenesReactivos->patchEntity($examenesReactivo, $this->request->getData());
            if ($this->ExamenesReactivos->save($examenesReactivo)) {
                $this->Flash->success(__('The examenes reactivo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The examenes reactivo could not be saved. Please, try again.'));
        }
        $reactivos = $this->ExamenesReactivos->Reactivos->find('list', limit: 200)->all();
        $this->set(compact('examenesReactivo', 'reactivos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Examenes Reactivo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $examenesReactivo = $this->ExamenesReactivos->get($id);
        if ($this->ExamenesReactivos->delete($examenesReactivo)) {
            $this->Flash->success(__('The examenes reactivo has been deleted.'));
        } else {
            $this->Flash->error(__('The examenes reactivo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
