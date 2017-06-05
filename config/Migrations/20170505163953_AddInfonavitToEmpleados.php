<?php
use Migrations\AbstractMigration;

class AddInfonavitToEmpleados extends AbstractMigration
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
        $table = $this->table('empleados');
        $table->addColumn('infonavit', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('sueldo', 'float', [
            'null' => false,
        ]);
        $table->addColumn('porcentaje_comision', 'float', [
            'null' => false,
        ]);
        $table->addColumn('empleado_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('joyeria', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('prestamo', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->update();
    }
}
