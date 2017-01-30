<?php

use Phinx\Migration\AbstractMigration;

class Games extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('games');
        $table->addColumn('user_id', 'integer', array('null' => false))
            ->addColumn('score', 'integer', array('default' => 0))
            ->addColumn('state', 'boolean', array('default' => 0))
            ->addColumn('updated_at', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('created_at', 'datetime')
            ->addIndex('user_id', array('unique' => true))
            ->addForeignKey('user_id', 'users', 'id', array('delete' => 'SET_NULL', 'update'=> 'NO_ACTION'))
            ->create();
    }
}
