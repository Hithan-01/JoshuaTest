<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExamenesReactivo $examenesReactivo
 * @var \Cake\Collection\CollectionInterface|string[] $reactivos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Examenes Reactivos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="examenesReactivos form content">
            <?= $this->Form->create($examenesReactivo) ?>
            <fieldset>
                <legend><?= __('Add Examenes Reactivo') ?></legend>
                <?php
                    echo $this->Form->control('examen_id');
                    echo $this->Form->control('reactivo_id', ['options' => $reactivos]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
