<?php
use Migrations\AbstractMigration;

class AddComisionToSucursales extends AbstractMigration
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
        $table->addColumn('comision', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('bono', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('cantidad_bono', 'float', [
            'null' => false,
        ]);
        $table->addColumn('minimo_venta', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('cantidad_minima_venta', 'float', [
            'null' => false,
        ]);
        $table->addColumn('comision_empleados', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('porcentaje_comision_empleados', 'float', [
            'null' => false,
        ]);
        $table->update();
    }
}
