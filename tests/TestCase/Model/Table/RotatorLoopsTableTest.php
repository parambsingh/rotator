<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RotatorLoopsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RotatorLoopsTable Test Case
 */
class RotatorLoopsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RotatorLoopsTable
     */
    protected $RotatorLoops;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.RotatorLoops',
        'app.UserPositions',
        'app.Leads',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RotatorLoops') ? [] : ['className' => RotatorLoopsTable::class];
        $this->RotatorLoops = $this->getTableLocator()->get('RotatorLoops', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RotatorLoops);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
