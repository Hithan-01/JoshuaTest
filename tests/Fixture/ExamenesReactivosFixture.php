<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExamenesReactivosFixture
 */
class ExamenesReactivosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'examen_id' => 1,
                'reactivo_id' => 1,
            ],
        ];
        parent::init();
    }
}
