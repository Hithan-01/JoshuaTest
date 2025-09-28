<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExamenesReactivo $examenesReactivo
 * @var string[]|\Cake\Collection\CollectionInterface $reactivos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $examenesReactivo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $examenesReactivo->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Examenes Reactivos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="examenesReactivos form content">
            <?= $this->Form->create($examenesReactivo) ?>
            <fieldset>
                <legend><?= __('Edit Examenes Reactivo') ?></legend>
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
