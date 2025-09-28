<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Examenes seed.
 */
class ExamenesSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'titulo' => 'Examen de Medicina General',
                'descripcion' => 'Evaluación básica de conocimientos médicos.',
                'user_id' => 1, // Asegúrate de que exista este usuario
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'titulo' => 'Examen de Cardiología',
                'descripcion' => 'Preguntas sobre patologías cardíacas.',
                'user_id' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $examenes = $this->table('examenes');
        $examenes->insert($data)->save();

        // Relacionar reactivos ya existentes
            $examenesReactivos = [
            [
                'examen_id' => 1,
                'reactivo_id' => 1,
            ],
            [
                'examen_id' => 1,
                'reactivo_id' => 2,
            ],
            [
                'examen_id' => 2,
                'reactivo_id' => 3,
            ],
        ];

        $junction = $this->table('examenes_reactivos');
        $junction->insert($examenesReactivos)->save();
    }
}
