<div class="login-container">
    <h1>Iniciar sesión</h1>

    <!-- Credenciales de prueba para el profesor -->
    <div class="credentials-info">
        <h3>Credenciales de Prueba:</h3>
        <div class="credential-card admin">
            <strong>Administrador:</strong><br>
            Email: admin@test.com<br>
            Password: 1234
        </div>
        <div class="credential-card student">
            <strong>Estudiante:</strong><br>
            Email: estudiante@gmail.com<br>
            Password: 1234
        </div>
    </div>

    <?= $this->Form->create() ?>
        <?= $this->Form->control('email', ['label' => 'Correo electrónico']) ?>
        <?= $this->Form->control('password', ['label' => 'Contraseña', 'type' => 'password']) ?>
        <?= $this->Form->button(__('Entrar')) ?>
    <?= $this->Form->end() ?>
</div>

<style>
.login-container {
    max-width: 400px;
    margin: 2rem auto;
    padding: 2rem;
}

.credentials-info {
    background: #f8f9fa;
    border: 2px solid #007bff;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.credentials-info h3 {
    margin-top: 0;
    color: #007bff;
    text-align: center;
}

.credential-card {
    background: white;
    padding: 1rem;
    margin: 1rem 0;
    border-radius: 5px;
    border-left: 4px solid #28a745;
}

.credential-card.admin {
    border-left-color: #dc3545;
}

.credential-card.student {
    border-left-color: #28a745;
}

.credential-card strong {
    color: #495057;
}
</style>