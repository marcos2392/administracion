<?php
use Migrations\AbstractMigration;

class AssPagodiarioToEmpleados extends AbstractMigration
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
        $table->addColumn('pago_diario', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('pago_diario_cantidad', 'float', [
            'default' => 0,
            'null' => false,
        ]);

        $table->update();
    }
}
