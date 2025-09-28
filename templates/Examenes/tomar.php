<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Examenes $examen
 */
?>

<div class="examen-container">
    <div class="examen-header">
        <div class="header-content">
            <h2><?= h($examen->titulo) ?></h2>
            <p class="description"><?= h($examen->descripcion ?: 'Responde todas las preguntas del examen') ?></p>
        </div>
        <div class="header-info">
            <span class="badge badge-info">
                <?= count($examen->reactivos) ?> preguntas
            </span>
        </div>
    </div>

    <?= $this->Form->create(null, ['type' => 'post', 'id' => 'examen-form']) ?>
    
    <div class="preguntas-container">
        <?php if (!empty($examen->reactivos)): ?>
            <?php foreach ($examen->reactivos as $index => $reactivo): ?>
                <div class="pregunta-card" data-pregunta="<?= $index + 1 ?>">
                    <div class="pregunta-header">
                        <span class="pregunta-numero">Pregunta <?= $index + 1 ?></span>
                    </div>
                    
                    <div class="pregunta-contenido">
                        <h5 class="pregunta-texto"><?= h($reactivo->pregunta) ?></h5>
                        
                        <div class="opciones">
                            <?php 
                            // Usar solo las 3 opciones que tienes en tu BD
                            $opciones = [
                                'A' => $reactivo->respuesta_a,
                                'B' => $reactivo->respuesta_b, 
                                'C' => $reactivo->respuesta_c
                            ];
                            
                            foreach ($opciones as $letra => $texto): 
                                if (!empty($texto) && trim($texto) !== ''): ?>
                                <div class="opcion-item">
                                    <label class="opcion-label">
                                        <input type="radio" 
                                               name="respuestas[<?= $reactivo->id ?>]" 
                                               value="<?= $letra ?>" 
                                               class="opcion-radio">
                                        <span class="opcion-letra"><?= $letra ?></span>
                                        <span class="opcion-texto"><?= h($texto) ?></span>
                                    </label>
                                </div>
                            <?php endif; 
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="examen-footer">
                <div class="footer-actions">
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> Volver a Exámenes',
                        ['action' => 'disponibles'],
                        ['class' => 'btn btn-secondary', 'escape' => false]
                    ) ?>
                    
                    <?= $this->Form->button(
                        '<i class="fas fa-paper-plane"></i> Enviar Examen',
                        [
                            'type' => 'submit',
                            'class' => 'btn btn-success',
                            'escape' => false,
                            'id' => 'enviar-examen'
                        ]
                    ) ?>
                </div>
                
                <div class="progreso-container">
                    <div class="progreso-info">
                        <span id="preguntas-respondidas">0</span> de <?= count($examen->reactivos) ?> preguntas respondidas
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
            
        <?php else: ?>
            <div class="alert alert-warning">
                <h5><i class="fas fa-exclamation-triangle"></i> Este examen no tiene preguntas</h5>
                <p>Este examen no tiene preguntas disponibles. Contacta con el administrador para más información.</p>
                <?= $this->Html->link(
                    'Volver a Exámenes',
                    ['action' => 'disponibles'],
                    ['class' => 'btn btn-primary']
                ) ?>
            </div>
        <?php endif; ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('examen-form');
    const radios = document.querySelectorAll('.opcion-radio');
    const totalPreguntas = <?= count($examen->reactivos) ?>;
    
    function actualizarProgreso() {
        const preguntasRespondidas = new Set();
        
        radios.forEach(radio => {
            if (radio.checked) {
                const nombrePregunta = radio.name;
                preguntasRespondidas.add(nombrePregunta);
            }
        });
        
        const respondidas = preguntasRespondidas.size;
        const porcentaje = totalPreguntas > 0 ? (respondidas / totalPreguntas) * 100 : 0;
        
        document.getElementById('preguntas-respondidas').textContent = respondidas;
        document.querySelector('.progress-bar').style.width = porcentaje + '%';
    }
    
    radios.forEach(radio => {
        radio.addEventListener('change', actualizarProgreso);
    });
    
    form.addEventListener('submit', function(e) {
        const respondidas = document.querySelectorAll('.opcion-radio:checked').length;
        
        if (respondidas === 0) {
            e.preventDefault();
            alert('Debes responder al menos una pregunta antes de enviar el examen.');
            return;
        }
        
        if (!confirm('¿Estás seguro de que quieres enviar el examen? No podrás modificar tus respuestas después.')) {
            e.preventDefault();
        }
    });
});
</script>

<style>
.examen-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.examen-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content h2 {
    margin: 0 0 10px 0;
    font-weight: 600;
}

.description {
    margin: 0;
    opacity: 0.9;
}

.badge-info {
    background-color: rgba(255,255,255,0.2);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
}

.pregunta-card {
    background: #fff;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.pregunta-header {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e9ecef;
}

.pregunta-numero {
    background: #667eea;
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
}

.pregunta-texto {
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
    line-height: 1.6;
}

.opciones {
    margin-left: 10px;
}

.opcion-item {
    margin-bottom: 15px;
}

.opcion-label {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #fff;
}

.opcion-label:hover {
    border-color: #667eea;
    background-color: #f8f9ff;
}

.opcion-radio {
    margin-right: 15px;
}

.opcion-letra {
    background: #667eea;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 15px;
    flex-shrink: 0;
}

.opcion-texto {
    flex: 1;
    line-height: 1.5;
}

.opcion-radio:checked + .opcion-letra {
    background: #28a745;
}

.examen-footer {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 12px;
    margin-top: 30px;
}

.footer-actions {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.btn {
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.progreso-container {
    text-align: center;
}

.progreso-info {
    margin-bottom: 10px;
    font-weight: 600;
    color: #666;
}

.progress {
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: width 0.3s ease;
}

.alert-warning {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
    padding: 15px;
    border-radius: 8px;
    margin: 10px 0;
}

@media (max-width: 768px) {
    .examen-container {
        padding: 10px;
    }
    
    .examen-header {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    
    .header-info {
        margin-top: 15px;
    }
    
    .footer-actions {
        flex-direction: column;
        gap: 10px;
    }
}
</style>