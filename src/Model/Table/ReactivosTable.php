<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ReactivosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reactivos');
        $this->setDisplayField('pregunta');
        $this->setPrimaryKey('id');

        // Relación muchos a muchos con Examenes
        $this->belongsToMany('Examenes', [
            'foreignKey' => 'reactivo_id',
            'targetForeignKey' => 'examen_id',
            'joinTable' => 'examenes_reactivos',
        ]);

        // Cada reactivo pertenece a un usuario
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('pregunta')
            ->notEmptyString('pregunta', 'La pregunta es obligatoria');

        return $validator;
    }
}
