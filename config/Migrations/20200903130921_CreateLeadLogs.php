<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateLeadLogs extends AbstractMigration
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
        $table = $this->table('lead_logs');
        $table->addColumn('lead_id', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('first_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('last_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('request_json', 'text', [
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
