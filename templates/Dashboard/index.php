<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="container" style="margin:50px auto; max-width:800px; text-align:center;">
    <h1>Panel de Control - Admin</h1>
    <p>Bienvenido <?= h($this->Identity->get('email')) ?></p>

    <div style="margin-top:30px;">
        <?= $this->Html->link(
            '➕ Añadir Reactivos',
            ['controller' => 'Reactivos', 'action' => 'add'],
            ['class' => 'btn btn-primary', 'style' => 'margin:10px; display:inline-block; padding:10px 20px; background:#007bff; color:#fff; border-radius:6px; text-decoration:none;']
        ) ?>

        <?= $this->Html->link(
            '👥 Ver Usuarios',
            ['controller' => 'Users', 'action' => 'index'],
            ['class' => 'btn btn-success', 'style' => 'margin:10px; display:inline-block; padding:10px 20px; background:#28a745; color:#fff; border-radius:6px; text-decoration:none;']
        ) ?>

        <?= $this->Html->link(
            '📋 Ver Reactivos',
            ['controller' => 'Reactivos', 'action' => 'index'],
            ['class' => 'btn btn-info', 'style' => 'margin:10px; display:inline-block; padding:10px 20px; background:#17a2b8; color:#fff; border-radius:6px; text-decoration:none;']
        ) ?>

        <?= $this->Html->link(
            '🚪 Logout',
            ['controller' => 'Users', 'action' => 'logout'],
            ['class' => 'btn btn-danger', 'style' => 'margin:10px; display:inline-block; padding:10px 20px; background:#dc3545; color:#fff; border-radius:6px; text-decoration:none;']
        ) ?>
    </div>
</div>
