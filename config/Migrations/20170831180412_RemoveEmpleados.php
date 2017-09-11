<?php
use Migrations\AbstractMigration;

class RemoveEmpleados extends AbstractMigration
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
        $table->removeColumn('pago_diario');
        $table->removeColumn('pago_diario_cantidad');
        $table->update();
    }
}
