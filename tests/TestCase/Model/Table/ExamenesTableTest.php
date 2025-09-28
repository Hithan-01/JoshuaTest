<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExamenesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExamenesTable Test Case
 */
class ExamenesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExamenesTable
     */
    protected $Examenes;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Examenes',
        'app.Users',
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
        $config = $this->getTableLocator()->exists('Examenes') ? [] : ['className' => ExamenesTable::class];
        $this->Examenes = $this->getTableLocator()->get('Examenes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Examenes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ExamenesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ExamenesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
