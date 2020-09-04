<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeadLogsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeadLogsTable Test Case
 */
class LeadLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LeadLogsTable
     */
    protected $LeadLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.LeadLogs',
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
        $config = $this->getTableLocator()->exists('LeadLogs') ? [] : ['className' => LeadLogsTable::class];
        $this->LeadLogs = $this->getTableLocator()->get('LeadLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LeadLogs);

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
