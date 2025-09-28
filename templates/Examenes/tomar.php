<?php
/**
 * Vista para tomar examen - Una pregunta por vez
 * templates/Examenes/tomar.php
 */
?>

<div class="examen-container">
    <div class="examen-header">
        <div class="examen-info">
            <h2><?= h($examen->titulo) ?></h2>
            <p class="text-muted"><?= h($examen->descripcion) ?></p>
        </div>
        <div class="progress-info">
            <span class="question-counter">
                <span id="current-question">1</span> de <?= count($examen->reactivos) ?> preguntas
            </span>
            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill"></div>
            </div>
        </div>
    </div>

    <?= $this->Form->create(null, [
        'id' => 'examen-form',
        'url' => ['action' => 'tomar', $examen->id]
    ]) ?>

    <div class="questions-container">
        <?php foreach ($examen->reactivos as $index => $reactivo): ?>
            <div class="question-slide" data-question="<?= $index + 1 ?>" style="<?= $index === 0 ? '' : 'display: none;' ?>">
                <div class="question-card">
                    <div class="question-header">
                        <span class="question-badge">Pregunta <?= $index + 1 ?></span>
                    </div>
                    
                    <div class="question-content">
                        <h4 class="question-text"><?= h($reactivo->pregunta) ?></h4>
                        
                        <div class="answers-container">
                            <?php 
                            $opciones = [
                                'A' => $reactivo->respuesta_a,
                                'B' => $reactivo->respuesta_b, 
                                'C' => $reactivo->respuesta_c,
                                'D' => $reactivo->respuesta_d ?? null
                            ];
                            ?>
                            
                            <?php foreach ($opciones as $letra => $respuesta): ?>
                                <?php if (!empty($respuesta)): ?>
                                    <label class="answer-option">
                                        <?= $this->Form->radio(
                                            "respuestas[{$reactivo->id}]",
                                            [
                                                $letra => ''
                                            ],
                                            [
                                                'hiddenField' => false,
                                                'class' => 'answer-radio'
                                            ]
                                        ) ?>
                                        <span class="answer-letter"><?= $letra ?></span>
                                        <span class="answer-text"><?= h($respuesta) ?></span>
                                    </label>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="navigation-controls">
        <button type="button" id="prev-btn" class="btn btn-outline-secondary" disabled>
            ← Anterior
        </button>
        
        <button type="button" id="next-btn" class="btn btn-primary">
            Siguiente →
        </button>
        
        <button type="submit" id="submit-btn" class="btn btn-success" style="display: none;">
            Finalizar Examen
        </button>
    </div>

    <?= $this->Form->end() ?>
</div>

<style>
.examen-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.examen-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
}

.examen-info h2 {
    margin: 0 0 10px 0;
    font-weight: 600;
}

.progress-info {
    margin-top: 20px;
}

.question-counter {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: rgba(255,255,255,0.3);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: #fff;
    width: 0%;
    transition: width 0.3s ease;
}

.questions-container {
    min-height: 400px;
    margin-bottom: 30px;
}

.question-slide {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

.question-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.question-header {
    background: #f8f9fa;
    padding: 15px 25px;
    border-bottom: 1px solid #e0e0e0;
}

.question-badge {
    background: #667eea;
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.9em;
    font-weight: 500;
}

.question-content {
    padding: 25px;
}

.question-text {
    color: #333;
    font-weight: 500;
    margin-bottom: 25px;
    line-height: 1.6;
}

.answers-container {
    space-y: 12px;
}

.answer-option {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #fff;
}

.answer-option:hover {
    border-color: #667eea;
    background: #f8f9ff;
}

.answer-option:has(.answer-radio:checked) {
    border-color: #667eea;
    background: #f0f4ff;
}

.answer-radio {
    margin-right: 15px;
    transform: scale(1.2);
}

.answer-letter {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    background: #667eea;
    color: white;
    border-radius: 50%;
    font-weight: 600;
    margin-right: 15px;
    font-size: 0.9em;
}

.answer-option:has(.answer-radio:checked) .answer-letter {
    background: #5a67d8;
}

.answer-text {
    flex: 1;
    font-weight: 500;
    color: #444;
}

.navigation-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
}

.btn {
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    background: transparent;
}

.btn-outline-secondary:hover:not(:disabled) {
    background: #6c757d;
    color: white;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a67d8;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .examen-container {
        padding: 10px;
    }
    
    .examen-header {
        padding: 20px;
    }
    
    .question-content {
        padding: 20px;
    }
    
    .navigation-controls {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalQuestions = <?= count($examen->reactivos) ?>;
    let currentQuestion = 1;
    
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');
    const currentQuestionSpan = document.getElementById('current-question');
    const progressFill = document.getElementById('progress-fill');
    
    function updateProgress() {
        const progress = (currentQuestion / totalQuestions) * 100;
        progressFill.style.width = progress + '%';
        currentQuestionSpan.textContent = currentQuestion;
    }
    
    function showQuestion(questionNum) {
        // Ocultar todas las preguntas
        document.querySelectorAll('.question-slide').forEach(slide => {
            slide.style.display = 'none';
        });
        
        // Mostrar la pregunta actual
        const currentSlide = document.querySelector(`[data-question="${questionNum}"]`);
        if (currentSlide) {
            currentSlide.style.display = 'block';
        }
        
        // Actualizar botones
        prevBtn.disabled = questionNum === 1;
        
        if (questionNum === totalQuestions) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            submitBtn.style.display = 'none';
        }
        
        updateProgress();
    }
    
    prevBtn.addEventListener('click', function() {
        if (currentQuestion > 1) {
            currentQuestion--;
            showQuestion(currentQuestion);
        }
    });
    
    nextBtn.addEventListener('click', function() {
        if (currentQuestion < totalQuestions) {
            currentQuestion++;
            showQuestion(currentQuestion);
        }
    });
    
    // Inicializar
    showQuestion(1);
});
</script>