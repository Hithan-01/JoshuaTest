<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title>Examenes Sistema</title>
    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css') ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">Examenes</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <?= $this->Html->link('Reactivos', ['controller' => 'Reactivos', 'action' => 'index'], ['class' => 'nav-link']) ?>
        </li>
        <?php if ($this->Identity->get('role') === 'admin'): ?>
        <li class="nav-item">
          <?= $this->Html->link('Usuarios', ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link']) ?>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'nav-link']) ?>
        </li>
      </ul>
      <span class="navbar-text text-white">
        <?= h($this->Identity->get('email')) ?>
      </span>
    </div>
  </div>
</nav>

<main class="container mt-4">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

</body>
</html>
