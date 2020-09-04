<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersPositionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersPositionsTable Test Case
 */
class UsersPositionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersPositionsTable
     */
    protected $UsersPositions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UsersPositions',
        'app.Users',
        'app.Subscriptions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UsersPositions') ? [] : ['className' => UsersPositionsTable::class];
        $this->UsersPositions = $this->getTableLocator()->get('UsersPositions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UsersPositions);

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
