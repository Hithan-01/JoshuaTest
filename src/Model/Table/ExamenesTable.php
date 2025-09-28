<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ExamenesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('examenes');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // Un examen pertenece a un usuario
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'INNER',
        ]);

        // Relación N-N con reactivos
        $this->belongsToMany('Reactivos', [
            'foreignKey'       => 'examen_id',   // 👈 corregido
            'targetForeignKey' => 'reactivo_id',
            'joinTable'        => 'examenes_reactivos',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 200)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo', 'El título es obligatorio');

        $validator
            ->scalar('descripcion')
            ->allowEmptyString('descripcion'); // 👈 más flexible

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id', 'El usuario es obligatorio');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), [
            'errorField' => 'user_id'
        ]);

        return $rules;
    }
}
