<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExamenesReactivo $examenesReactivo
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Examenes Reactivo'), ['action' => 'edit', $examenesReactivo->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Examenes Reactivo'), ['action' => 'delete', $examenesReactivo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $examenesReactivo->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Examenes Reactivos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Examenes Reactivo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="examenesReactivos view content">
            <h3><?= h($examenesReactivo->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Reactivo') ?></th>
                    <td><?= $examenesReactivo->hasValue('reactivo') ? $this->Html->link($examenesReactivo->reactivo->respuesta_a, ['controller' => 'Reactivos', 'action' => 'view', $examenesReactivo->reactivo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($examenesReactivo->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Examen Id') ?></th>
                    <td><?= $this->Number->format($examenesReactivo->examen_id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>