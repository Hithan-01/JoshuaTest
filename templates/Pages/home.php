<?php
/**
 * Página de inicio personalizada
 * @var \App\View\AppView $this
 */
$this->disableAutoLayout();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exámenes - Home</title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css(['normalize.min', 'milligram.min']) ?>
    <style>
        body {
            background: #f9f9f9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        p {
            margin-bottom: 30px;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido a Exámenes</h1>
        <p>Selecciona una opción para continuar:</p>

        <?= $this->Html->link(
            'Sign In',
            ['controller' => 'Users', 'action' => 'login'],
            ['class' => 'btn btn-primary']
        ) ?>

        <?= $this->Html->link(
            'Sign Up',
            ['controller' => 'Users', 'action' => 'add'],
            ['class' => 'btn btn-success']
        ) ?>
    </div>
</body>
</html>
