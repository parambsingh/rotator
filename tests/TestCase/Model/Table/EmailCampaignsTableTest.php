<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailCampaignsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailCampaignsTable Test Case
 */
class EmailCampaignsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailCampaignsTable
     */
    protected $EmailCampaigns;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.EmailCampaigns',
        'app.EmailTemplates',
        'app.EmailCampaignRecipients',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EmailCampaigns') ? [] : ['className' => EmailCampaignsTable::class];
        $this->EmailCampaigns = $this->getTableLocator()->get('EmailCampaigns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EmailCampaigns);

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
