<?php
/**
 * Vista Dashboard completa según el documento original
 * templates/Pages/dashboard.php
 */
?>

<div class="dashboard">
    <?php if ($user->get('role') === 'admin'): ?>
        <div class="admin-dashboard">
            <h2>Panel de Administración</h2>
            
            <div class="row">
                <div class="column">
                    <div class="dashboard-card">
                        <h3>Estadísticas del Sistema</h3>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-number"><?= $totalUsers ?></div>
                                <div class="stat-label">Total de Usuarios</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number"><?= $totalReactivos ?></div>
                                <div class="stat-label">Total de Reactivos</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">
                                    <?php 
                                    $admins = 0;
                                    foreach ($allUsers ?? [] as $u) {
                                        if ($u->role === 'admin') $admins++;
                                    }
                                    echo $admins;
                                    ?>
                                </div>
                                <div class="stat-label">Administradores</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">
                                    <?php 
                                    $estudiantes = 0;
                                    foreach ($allUsers ?? [] as $u) {
                                        if ($u->role === 'estudiante') $estudiantes++;
                                    }
                                    echo $estudiantes;
                                    ?>
                                </div>
                                <div class="stat-label">Estudiantes</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="column">
                    <div class="dashboard-card">
                        <h3>Acciones Rápidas</h3>
                        <div class="quick-actions">
                            <?= $this->Html->link('👥 Gestionar Usuarios', 
                                ['controller' => 'Users', 'action' => 'index'], 
                                ['class' => 'quick-action-btn users']
                            ) ?>
                            
                            <?= $this->Html->link('📝 Ver Todos los Reactivos', 
                                ['controller' => 'Reactivos', 'action' => 'index'], 
                                ['class' => 'quick-action-btn reactivos']
                            ) ?>
                            
                            <?= $this->Html->link('➕ Crear Reactivo', 
                                ['controller' => 'Reactivos', 'action' => 'add'], 
                                ['class' => 'quick-action-btn add']
                            ) ?>
                            
                            <?= $this->Html->link('📊 Ver Exámenes', 
                                ['controller' => 'Examenes', 'action' => 'index'], 
                                ['class' => 'quick-action-btn examenes']
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-card full-width">
                <h3>Distribución de Reactivos por Especialidad</h3>
                <div class="specialties-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Área de Especialidad</th>
                                <th>Cantidad de Reactivos</th>
                                <th>Porcentaje del Total</th>
                                <th>Última Actualización</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reactivosPorEspecialidad)): ?>
                                <?php foreach ($reactivosPorEspecialidad as $especialidad): ?>
                                <tr>
                                    <td>
                                        <span class="specialty-name"><?= h($especialidad->area_especialidad) ?></span>
                                    </td>
                                    <td>
                                        <span class="count-badge"><?= h($especialidad->count) ?></span>
                                    </td>
                                    <td>
                                        <?php 
                                        $porcentaje = $totalReactivos > 0 ? round(($especialidad->count / $totalReactivos) * 100, 1) : 0;
                                        ?>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?= $porcentaje ?>%"></div>
                                            <span class="progress-text"><?= $porcentaje ?>%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">Hace 2 días</small>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="empty-state">
                                            <p>No hay reactivos creados aún</p>
                                            <?= $this->Html->link('Crear el primer reactivo', 
                                                ['controller' => 'Reactivos', 'action' => 'add'], 
                                                ['class' => 'button button-primary']
                                            ) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="column">
                    <div class="dashboard-card">
                        <h3>Actividad Reciente</h3>
                        <div class="activity-feed">
                            <div class="activity-item">
                                <div class="activity-icon">📝</div>
                                <div class="activity-content">
                                    <p><strong>Nuevo reactivo creado</strong></p>
                                    <small>Hace 1 hora</small>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">👤</div>
                                <div class="activity-content">
                                    <p><strong>Usuario registrado</strong></p>
                                    <small>Hace 3 horas</small>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">✏️</div>
                                <div class="activity-content">
                                    <p><strong>Reactivo editado</strong></p>
                                    <small>Hace 1 día</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="column">
                    <div class="dashboard-card">
                        <h3>Información del Sistema</h3>
                        <div class="system-info">
                            <div class="info-item">
                                <strong>Versión del Sistema:</strong> 1.0.0
                            </div>
                            <div class="info-item">
                                <strong>Base de Datos:</strong> PostgreSQL
                            </div>
                            <div class="info-item">
                                <strong>Framework:</strong> CakePHP 5
                            </div>
                            <div class="info-item">
                                <strong>Último Backup:</strong> Hoy, 08:00 AM
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <div class="user-dashboard">
            <h2>Panel de Usuario Base</h2>
            
            <div class="welcome-message">
                <h3>Bienvenido, <?= h($user->email) ?></h3>
                <p>Desde aquí puedes gestionar tus reactivos y acceder a las funcionalidades del sistema.</p>
            </div>
            
            <div class="row">
                <div class="column">
                    <div class="dashboard-card">
                        <h3>Mis Estadísticas</h3>
                        <div class="user-stats">
                            <div class="stat-circle">
                                <div class="stat-number"><?= $misReactivos ?></div>
                                <div class="stat-label">Reactivos Creados</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="column">
                    <div class="dashboard-card">
                        <h3>Acciones Disponibles</h3>
                        <div class="user-actions">
                            <?= $this->Html->link('📝 Ver Mis Reactivos', 
                                ['controller' => 'Reactivos', 'action' => 'index'], 
                                ['class' => 'action-btn primary']
                            ) ?>
                            
                            <?= $this->Html->link('➕ Crear Nuevo Reactivo', 
                                ['controller' => 'Reactivos', 'action' => 'add'], 
                                ['class' => 'action-btn secondary']
                            ) ?>
                            
                            <?= $this->Html->link('📋 Exámenes Disponibles', 
                                ['controller' => 'Examenes', 'action' => 'disponibles'], 
                                ['class' => 'action-btn tertiary']
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-card full-width">
                <h3>Guía de Usuario</h3>
                <div class="user-guide">
                    <div class="guide-section">
                        <h4>📝 Creación de Reactivos</h4>
                        <p>Puedes crear preguntas de examen especificando la especialidad médica, nivel de dificultad y retroalimentación.</p>
                    </div>
                    <div class="guide-section">
                        <h4>✏️ Gestión de Contenido</h4>
                        <p>Edita y elimina tus propios reactivos. Solo puedes modificar el contenido que hayas creado.</p>
                    </div>
                    <div class="guide-section">
                        <h4>📋 Tomar Exámenes</h4>
                        <p>Accede a los exámenes disponibles y responde las preguntas para evaluar tus conocimientos.</p>
                    </div>
                    <div class="guide-section">
                        <h4>📊 Seguimiento</h4>
                        <p>Ve estadísticas de tus reactivos creados y tu progreso en el sistema.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.dashboard {
    padding: 2rem 0;
    background-color: #f8f9fa;
    min-height: 80vh;
}

.dashboard h2 {
    color: #2c3e50;
    margin-bottom: 2rem;
    text-align: center;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: -1rem;
}

.column {
    flex: 1;
    padding: 1rem;
    min-width: 300px;
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    height: 100%;
}

.dashboard-card.full-width {
    margin: 1rem 0;
}

.dashboard-card h3 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    font-weight: 600;
    border-bottom: 2px solid #3498db;
    padding-bottom: 0.5rem;
}

/* Estadísticas Admin */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 8px;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Acciones Rápidas */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.quick-action-btn {
    display: block;
    padding: 1rem;
    text-align: center;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.quick-action-btn.users {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.quick-action-btn.reactivos {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
}

.quick-action-btn.add {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
}

.quick-action-btn.examenes {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Tabla de Especialidades */
.specialties-table {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #2c3e50;
}

.specialty-name {
    font-weight: 600;
    color: #2c3e50;
}

.count-badge {
    background: #3498db;
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
}

.progress-bar {
    position: relative;
    background: #e9ecef;
    border-radius: 10px;
    height: 20px;
    overflow: hidden;
}

.progress-fill {
    background: linear-gradient(90deg, #3498db, #2980b9);
    height: 100%;
    transition: width 0.3s ease;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.8rem;
    font-weight: 600;
    color: #2c3e50;
}

/* Actividad Reciente */
.activity-feed {
    space-y: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.activity-icon {
    font-size: 1.5rem;
    margin-right: 1rem;
}

.activity-content p {
    margin: 0;
    font-weight: 500;
}

.activity-content small {
    color: #6c757d;
}

/* Información del Sistema */
.system-info {
    space-y: 1rem;
}

.info-item {
    padding: 0.8rem;
    background: #f8f9fa;
    border-radius: 6px;
    margin-bottom: 0.5rem;
}

/* Dashboard de Usuario */
.welcome-message {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
}

.welcome-message h3 {
    margin: 0 0 1rem 0;
    color: white;
}

.user-stats {
    text-align: center;
}

.stat-circle {
    display: inline-block;
    padding: 2rem;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border-radius: 50%;
    min-width: 120px;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.stat-circle .stat-number {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.user-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.action-btn {
    display: block;
    padding: 1rem;
    text-align: center;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.action-btn.primary {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.action-btn.secondary {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
}

.action-btn.tertiary {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Guía de Usuario */
.user-guide {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.guide-section {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #3498db;
}

.guide-section h4 {
    color: #2c3e50;
    margin: 0 0 1rem 0;
}

.guide-section p {
    color: #6c757d;
    margin: 0;
    line-height: 1.5;
}

.empty-state {
    text-align: center;
    padding: 2rem;
}

.text-center {
    text-align: center;
}

.text-muted {
    color: #6c757d;
}

/* Responsive */
@media (max-width: 768px) {
    .stats-grid,
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .row {
        flex-direction: column;
    }
    
    .user-guide {
        grid-template-columns: 1fr;
    }
    
    .dashboard {
        padding: 1rem 0;
    }
    
    .dashboard-card {
        padding: 1rem;
    }
}
</style>