<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WebinarAccountsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WebinarAccountsTable Test Case
 */
class WebinarAccountsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WebinarAccountsTable
     */
    protected $WebinarAccounts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.WebinarAccounts',
        'app.Clients',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('WebinarAccounts') ? [] : ['className' => WebinarAccountsTable::class];
        $this->WebinarAccounts = $this->getTableLocator()->get('WebinarAccounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->WebinarAccounts);

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
