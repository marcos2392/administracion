<?php
use Migrations\AbstractMigration;

class RemoveExtrasEmpleadoToEmpleados extends AbstractMigration
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
        $table->removeColumn('entrada');
        $table->removeColumn('salida');
        $table->removeColumn('dia_extra');
        $table->removeColumn('tipo_extra');
        $table->removeColumn('horario_mixto');
        $table->update();
    }
}
