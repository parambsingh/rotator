<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailTemplatesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailTemplatesTable Test Case
 */
class EmailTemplatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailTemplatesTable
     */
    protected $EmailTemplates;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.EmailTemplates',
        'app.Users',
        'app.EmailCampaigns',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EmailTemplates') ? [] : ['className' => EmailTemplatesTable::class];
        $this->EmailTemplates = $this->getTableLocator()->get('EmailTemplates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EmailTemplates);

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
