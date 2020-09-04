<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateRotatorLoops extends AbstractMigration
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
        $table = $this->table('rotator_loops');
        $table->addColumn('round_no', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('user_position_id', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('lead_id', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('lead_status', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('rf_status', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('rf_response_json', 'text', [
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
