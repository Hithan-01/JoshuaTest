<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RespuestasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RespuestasTable Test Case
 */
class RespuestasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RespuestasTable
     */
    protected $Respuestas;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Respuestas',
        'app.Reactivos',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Respuestas') ? [] : ['className' => RespuestasTable::class];
        $this->Respuestas = $this->getTableLocator()->get('Respuestas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Respuestas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RespuestasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RespuestasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
