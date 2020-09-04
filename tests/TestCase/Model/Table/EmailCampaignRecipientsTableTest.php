<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailCampaignRecipientsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailCampaignRecipientsTable Test Case
 */
class EmailCampaignRecipientsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailCampaignRecipientsTable
     */
    protected $EmailCampaignRecipients;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.EmailCampaignRecipients',
        'app.EmailCampaigns',
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
        $config = $this->getTableLocator()->exists('EmailCampaignRecipients') ? [] : ['className' => EmailCampaignRecipientsTable::class];
        $this->EmailCampaignRecipients = $this->getTableLocator()->get('EmailCampaignRecipients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EmailCampaignRecipients);

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
