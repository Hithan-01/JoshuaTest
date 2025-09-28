<h1>Iniciar sesión</h1>

<?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['label' => 'Correo electrónico']) ?>
    <?= $this->Form->control('password', ['label' => 'Contraseña', 'type' => 'password']) ?>
    <?= $this->Form->button(__('Entrar')) ?>
<?= $this->Form->end() ?>
