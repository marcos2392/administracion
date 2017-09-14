<?php
use Migrations\AbstractMigration;

class AddSaldoAnteriorToMovimientosProveedores extends AbstractMigration
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
        $table = $this->table('movimientos_proveedores');
        $table->addColumn('saldo_anterior', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
