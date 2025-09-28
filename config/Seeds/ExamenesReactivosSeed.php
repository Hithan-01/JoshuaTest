<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class ExamenesReactivosSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['examen_id' => 1, 'reactivo_id' => 1],
            ['examen_id' => 1, 'reactivo_id' => 2],
            ['examen_id' => 1, 'reactivo_id' => 3],
        ];

        $table = $this->table('examenes_reactivos');
        $table->insert($data)->save();
    }
}
