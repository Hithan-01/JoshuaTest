<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Examene $examene
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $reactivos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $examene->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $examene->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Examenes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="examenes form content">
            <?= $this->Form->create($examene) ?>
            <fieldset>
                <legend><?= __('Edit Examene') ?></legend>
                <?php
                    echo $this->Form->control('titulo');
                    echo $this->Form->control('descripcion');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('reactivos._ids', ['options' => $reactivos]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
