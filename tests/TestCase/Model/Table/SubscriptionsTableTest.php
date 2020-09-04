<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubscriptionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubscriptionsTable Test Case
 */
class SubscriptionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SubscriptionsTable
     */
    protected $Subscriptions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Subscriptions',
        'app.Plans',
        'app.Users',
        'app.Coupons',
        'app.UsersPositions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Subscriptions') ? [] : ['className' => SubscriptionsTable::class];
        $this->Subscriptions = $this->getTableLocator()->get('Subscriptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Subscriptions);

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
