<?php
use Migrations\AbstractMigration;

class AddCajaToSucursales extends AbstractMigration
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
        $table = $this->table('sucursales');
        $table->addColumn('caja', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
