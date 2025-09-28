<h1><?= h($examen->titulo) ?></h1>
<p><?= h($examen->descripcion) ?></p>

<?= $this->Form->create(null) ?>
<?php foreach ($examen->reactivos as $reactivo): ?>
    <div class="pregunta">
        <h4><?= h($reactivo->pregunta) ?></h4>
        <?= $this->Form->textarea("respuestas.{$reactivo->id}", ['rows' => 2]) ?>
    </div>
<?php endforeach; ?>
<?= $this->Form->button('Enviar respuestas') ?>
<?= $this->Form->end() ?>
