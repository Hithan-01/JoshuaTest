<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class ReactivosSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'pregunta' => '¿Cuál es la capital de Francia?',
                'respuesta_a' => 'Madrid',
                'respuesta_b' => 'París',
                'respuesta_c' => 'Roma',
                'respuesta_correcta' => 'B',
                'retroalimentacion' => 'París es la capital de Francia.',
                'dificultad' => 1,
                'area_especialidad' => 'Geografía',
                'subespecialidad' => 'Europa',
                'user_id' => 1, // 👈 asumiendo que tu admin tiene id=1
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'pregunta' => '¿Cuánto es 5 x 6?',
                'respuesta_a' => '30',
                'respuesta_b' => '25',
                'respuesta_c' => '35',
                'respuesta_correcta' => 'A',
                'retroalimentacion' => '5 por 6 = 30.',
                'dificultad' => 1,
                'area_especialidad' => 'Matemáticas',
                'subespecialidad' => 'Aritmética',
                'user_id' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'pregunta' => '¿Quién escribió “Cien años de soledad”?',
                'respuesta_a' => 'Pablo Neruda',
                'respuesta_b' => 'Gabriel García Márquez',
                'respuesta_c' => 'Mario Vargas Llosa',
                'respuesta_correcta' => 'B',
                'retroalimentacion' => 'Gabriel García Márquez ganó el Nobel y escribió esta obra.',
                'dificultad' => 2,
                'area_especialidad' => 'Literatura',
                'subespecialidad' => 'Latinoamericana',
                'user_id' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('reactivos');
        $table->insert($data)->save();
    }
}
