<?php
use Migrations\AbstractMigration;

class CreateVentasSucursales extends AbstractMigration
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
        $table = $this->table('ventas_sucursales');
        $table->addColumn('venta', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
