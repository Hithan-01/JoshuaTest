<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Examene $examene
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $reactivos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Acciones') ?></h4>
            <?= $this->Html->link(
                __('Lista de Exámenes'),
                ['action' => 'index'],
                ['class' => 'side-nav-item']
            ) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="examenes form content">
            <?= $this->Form->create($examene) ?>
            <fieldset>
                <legend><?= __('Crear Examen') ?></legend>
                <?php
                    echo $this->Form->control('titulo', [
                        'label' => 'Título del examen',
                        'required' => true,
                        'class' => 'form-control'
                    ]);
                    echo $this->Form->control('descripcion', [
                        'label' => 'Descripción',
                        'rows' => 3,
                        'class' => 'form-control'
                    ]);
                    echo $this->Form->control('user_id', [
                        'label' => 'Autor',
                        'options' => $users,
                        'empty' => '-- Selecciona un usuario --',
                        'class' => 'form-select'
                    ]);
                    echo $this->Form->control('reactivos._ids', [
                        'options' => $reactivos,
                        'multiple' => true,
                        'label' => 'Selecciona los Reactivos',
                        'class' => 'form-select'
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Crear Examen'), [
                'class' => 'btn btn-primary'
            ]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
