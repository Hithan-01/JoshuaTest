<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExamenesReactivo Entity
 *
 * @property int $id
 * @property int $examen_id
 * @property int $reactivo_id
 *
 * @property \App\Model\Entity\Reactivo $reactivo
 */
class ExamenesReactivo extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'examen_id' => true,
        'reactivo_id' => true,
        'reactivo' => true,
    ];
}
