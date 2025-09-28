<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExamenesReactivos Model
 *
 * @property \App\Model\Table\ReactivosTable&\Cake\ORM\Association\BelongsTo $Reactivos
 *
 * @method \App\Model\Entity\ExamenesReactivo newEmptyEntity()
 * @method \App\Model\Entity\ExamenesReactivo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ExamenesReactivo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExamenesReactivo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ExamenesReactivo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ExamenesReactivo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ExamenesReactivo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExamenesReactivo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ExamenesReactivo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ExamenesReactivo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ExamenesReactivo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ExamenesReactivo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ExamenesReactivo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ExamenesReactivo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ExamenesReactivo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ExamenesReactivo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ExamenesReactivo> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ExamenesReactivosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('examenes_reactivos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Reactivos', [
            'foreignKey' => 'reactivo_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('examen_id')
            ->requirePresence('examen_id', 'create')
            ->notEmptyString('examen_id');

        $validator
            ->integer('reactivo_id')
            ->notEmptyString('reactivo_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['reactivo_id'], 'Reactivos'), ['errorField' => 'reactivo_id']);

        return $rules;
    }
}
