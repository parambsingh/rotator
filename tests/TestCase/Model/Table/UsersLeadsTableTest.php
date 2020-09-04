<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersLeadsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersLeadsTable Test Case
 */
class UsersLeadsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersLeadsTable
     */
    protected $UsersLeads;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UsersLeads',
        'app.Users',
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
        $config = $this->getTableLocator()->exists('UsersLeads') ? [] : ['className' => UsersLeadsTable::class];
        $this->UsersLeads = $this->getTableLocator()->get('UsersLeads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UsersLeads);

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
