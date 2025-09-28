<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Examenes> $examenes
 */
?>

<div class="examenes index content">
    <div class="header-section">
        <h3><?= __('Exámenes Disponibles') ?></h3>
        <p class="text-muted mb-4">Selecciona un examen para comenzar a responder las preguntas.</p>
    </div>

    <div class="examenes-grid">
        <?php if (!empty($examenes->toArray())): ?>
            <?php foreach ($examenes as $examen): ?>
                <div class="examen-card">
                    <div class="card-header">
                        <h5 class="card-title"><?= h($examen->titulo) ?></h5>
                        <small class="text-muted">
                            Autor: <?= h($examen->user->email ?? 'N/A') ?>
                        </small>
                    </div>
                    
                    <div class="card-body">
                        <p class="card-description">
                            <?= h($examen->descripcion ?: 'Sin descripción disponible') ?>
                        </p>
                        
                        <div class="card-meta">
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> 
                                Creado: <?= h($examen->created->format('d/m/Y H:i')) ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <?= $this->Html->link(
                            '<i class="fas fa-play-circle"></i> Comenzar Examen',
                            ['action' => 'tomar', $examen->id],
                            [
                                'class' => 'btn btn-primary btn-block',
                                'escape' => false,
                                'confirm' => '¿Estás listo para comenzar este examen? Una vez que inicies, deberás completarlo.'
                            ]
                        ) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-examenes">
                <div class="empty-state">
                    <i class="fas fa-clipboard-list fa-3x"></i>
                    <h5>No hay exámenes disponibles</h5>
                    <p>Por el momento no hay exámenes para realizar. Consulta más tarde.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.examenes.index.content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.header-section {
    text-align: center;
    margin-bottom: 40px;
}

.header-section h3 {
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
}

.examenes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
}

.examen-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    overflow: hidden;
}

.examen-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
}

.card-title {
    margin: 0 0 8px 0;
    font-weight: 600;
    font-size: 1.2em;
}

.card-body {
    padding: 20px;
}

.card-description {
    color: #666;
    line-height: 1.5;
    margin-bottom: 15px;
    min-height: 48px;
}

.card-meta {
    border-top: 1px solid #f0f0f0;
    padding-top: 15px;
}

.card-meta i {
    margin-right: 5px;
}

.card-actions {
    padding: 0 20px 20px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 12px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
}

.btn-block {
    width: 100%;
    display: block;
}

.no-examenes {
    grid-column: 1/-1;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-state i {
    color: #ccc;
    margin-bottom: 20px;
}

.empty-state h5 {
    margin-bottom: 10px;
    color: #333;
}

@media (max-width: 768px) {
    .examenes-grid {
        grid-template-columns: 1fr;
    }
    
    .examenes.index.content {
        padding: 10px;
    }
}
</style>