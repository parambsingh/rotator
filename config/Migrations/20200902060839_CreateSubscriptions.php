<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSubscriptions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('subscriptions');
        $table->addColumn('plan_id', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('user_id', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('coupon_id', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('subscription_token', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('amount', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('discount', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('start_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('end_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('response_json', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('status', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('cancelled_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
