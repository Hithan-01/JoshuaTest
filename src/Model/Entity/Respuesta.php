<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class RespuestaTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('respuestas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // Relaciones
        $this->belongsTo('Examenes', [
            'foreignKey' => 'examen_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Reactivos', [
            'foreignKey' => 'reactivo_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('examen_id')
            ->requirePresence('examen_id', 'create')
            ->notEmptyString('examen_id');

        $validator
            ->integer('reactivo_id')
            ->requirePresence('reactivo_id', 'create')
            ->notEmptyString('reactivo_id');

        $validator
            ->integer('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id');

        $validator
            ->scalar('respuesta_usuario')
            ->maxLength('respuesta_usuario', 255)
            ->requirePresence('respuesta_usuario', 'create')
            ->notEmptyString('respuesta_usuario');

        return $validator;
    }
}