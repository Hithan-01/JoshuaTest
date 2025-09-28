<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Examene> $examenes
 */
?>
<div class="examenes index content">
    <?= $this->Html->link(
        __('Nuevo Examen'),
        ['action' => 'add'],
        ['class' => 'button float-right btn btn-primary']
    ) ?>
    <h3><?= __('Exámenes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('titulo', 'Título') ?></th>
                    <th><?= $this->Paginator->sort('descripcion', 'Descripción') ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'Autor') ?></th>
                    <th><?= __('Reactivos Asociados') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                    <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                    <th class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($examenes as $examene): ?>
                <tr>
                    <td><?= $this->Number->format($examene->id) ?></td>
                    <td><?= h($examene->titulo) ?></td>
                    <td><?= h($examene->descripcion) ?></td>
                    <td>
                        <?= $examene->has('user')
                            ? h($examene->user->email)
                            : __('(Sin autor)') ?>
                    </td>
                    <td>
                        <?php if (!empty($examene->reactivos)): ?>
                            <ul>
                                <?php foreach ($examene->reactivos as $reactivo): ?>
                                    <li>
                                        <?= h($reactivo->pregunta) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <em><?= __('Ningún reactivo asociado') ?></em>
                        <?php endif; ?>
                    </td>
                    <td><?= h($examene->created) ?></td>
                    <td><?= h($examene->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $examene->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $examene->id]) ?>
                        <?= $this->Form->postLink(
                            __('Eliminar'),
                            ['action' => 'delete', $examene->id],
                            ['confirm' => __('¿Seguro que quieres eliminar el examen con ID {0}?', $examene->id)]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primero')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
        </ul>
        <p>
            <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} total')) ?>
        </p>
    </div>
</div>
