<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateRespuestas extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('respuestas');
        $table->addColumn('examen_id', 'integer', [
            'default' => null,
            'null' => false,
        ])
        ->addColumn('reactivo_id', 'integer', [
            'default' => null,
            'null' => false,
        ])
        ->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => false,
        ])
        ->addColumn('respuesta_usuario', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ])
        ->addIndex(['examen_id'])
        ->addIndex(['reactivo_id'])
        ->addIndex(['user_id'])
        ->addForeignKey('examen_id', 'examenes', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION'
        ])
        ->addForeignKey('reactivo_id', 'reactivos', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION'
        ])
        ->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION'
        ])
        ->create();
    }
}