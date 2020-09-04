<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsersPositions extends AbstractMigration
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
        $table = $this->table('users_positions');
        $table->addColumn('user_id', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('subscription_id', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('position_no', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('position_order', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('subscription_status', 'string', [
            'default' => null,
            'limit' => 255,
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
