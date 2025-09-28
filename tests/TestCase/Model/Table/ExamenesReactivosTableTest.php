<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExamenesReactivosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExamenesReactivosTable Test Case
 */
class ExamenesReactivosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExamenesReactivosTable
     */
    protected $ExamenesReactivos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ExamenesReactivos',
        'app.Reactivos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExamenesReactivos') ? [] : ['className' => ExamenesReactivosTable::class];
        $this->ExamenesReactivos = $this->getTableLocator()->get('ExamenesReactivos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ExamenesReactivos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ExamenesReactivosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ExamenesReactivosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
