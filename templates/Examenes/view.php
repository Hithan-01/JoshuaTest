<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Examene $examene
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Acciones') ?></h4>
            <?= $this->Html->link(__('Editar Examen'), ['action' => 'edit', $examene->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(
                __('Eliminar Examen'),
                ['action' => 'delete', $examene->id],
                ['confirm' => __('¿Seguro que deseas eliminar el examen con ID {0}?', $examene->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('Lista de Exámenes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Nuevo Examen'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="examenes view content">
            <h3><?= h($examene->titulo) ?></h3>
            <table>
                <tr>
                    <th><?= __('Título') ?></th>
                    <td><?= h($examene->titulo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Descripción') ?></th>
                    <td><?= h($examene->descripcion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Autor') ?></th>
                    <td>
                        <?= $examene->has('user') ? h($examene->user->email) : __('(Sin autor)') ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($examene->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Creado') ?></th>
                    <td><?= h($examene->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modificado') ?></th>
                    <td><?= h($examene->modified) ?></td>
                </tr>
            </table>

            <div class="related">
                <h4><?= __('Reactivos Asociados') ?></h4>
                <?php if (!empty($examene->reactivos)): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Pregunta') ?></th>
                                <th><?= __('Respuesta Correcta') ?></th>
                                <th><?= __('Dificultad') ?></th>
                                <th><?= __('Área Especialidad') ?></th>
                                <th><?= __('Subespecialidad') ?></th>
                                <th><?= __('Creado') ?></th>
                                <th><?= __('Modificado') ?></th>
                                <th class="actions"><?= __('Acciones') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($examene->reactivos as $reactivo): ?>
                            <tr>
                                <td><?= h($reactivo->id) ?></td>
                                <td><?= h($reactivo->pregunta) ?></td>
                                <td><?= h($reactivo->respuesta_correcta) ?></td>
                                <td><?= h($reactivo->dificultad) ?></td>
                                <td><?= h($reactivo->area_especialidad) ?></td>
                                <td><?= h($reactivo->subespecialidad) ?></td>
                                <td><?= h($reactivo->created) ?></td>
                                <td><?= h($reactivo->modified) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Reactivos', 'action' => 'view', $reactivo->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Reactivos', 'action' => 'edit', $reactivo->id]) ?>
                                    <?= $this->Form->postLink(
                                        __('Eliminar'),
                                        ['controller' => 'Reactivos', 'action' => 'delete', $reactivo->id],
                                        ['confirm' => __('¿Seguro que deseas eliminar el reactivo con ID {0}?', $reactivo->id)]
                                    ) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <em><?= __('Este examen no tiene reactivos asociados.') ?></em>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
