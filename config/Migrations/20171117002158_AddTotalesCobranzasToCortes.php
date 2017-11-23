<?php
use Migrations\AbstractMigration;

class AddTotalesCobranzasToCortes extends AbstractMigration
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
        $table = $this->table('cortes');
        $table->addColumn('total_sucursales', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('total_cobrador', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
