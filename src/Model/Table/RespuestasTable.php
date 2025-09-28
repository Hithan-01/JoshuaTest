<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class RespuestasTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('respuestas');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Examenes', [
            'foreignKey' => 'examen_id',
        ]);
        $this->belongsTo('Reactivos', [
            'foreignKey' => 'reactivo_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('examen_id')->notEmptyString('examen_id')
            ->integer('reactivo_id')->notEmptyString('reactivo_id')
            ->integer('user_id')->notEmptyString('user_id');

        return $validator;
    }
}
