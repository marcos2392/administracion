<?php
use Migrations\AbstractMigration;

class CreateNominaEmpleadas extends AbstractMigration
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
        $table = $this->table('nomina_empleadas');
        $table->addColumn('empleados_id', 'integer', [
            'default' => null,
            'limit' => 11,
        ]);
        $table->addColumn('fecha', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('fecha_inicio', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('fecha_fin', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('sucursal_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('horas', 'time', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('sueldo', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('infonavit', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('bono', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('comision', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('deduccion', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('extra', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('prestamo', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('joyeria', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('sueldo_final', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
