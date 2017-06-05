<?php
use Migrations\AbstractMigration;

class CreateEmpleados extends AbstractMigration
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
        
        $table->addColumn('nombre', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('apellidos', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('status', 'boolean', [
            'default' => true,
            'null' => false,
        ]);
        $table->addColumn('descanso', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('entrada', 'time', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('salida', 'time', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('sucursal_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('dia_extra', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('tipo_extra', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
