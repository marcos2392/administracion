<?php
use Migrations\AbstractMigration;

class AddPermisosToUsuarios extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('usuarios');
        $table->addColumn('checador', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('nominas', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('caja', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
