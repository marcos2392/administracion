<?php
use Migrations\AbstractMigration;

class ChangeCantidadesToMovimientosProveedores extends AbstractMigration
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
        $table->changeColumn('cantidad', 'decimal', [
            'null' => false,
            'default' => 0,
            'precision'=> 10,
            'scale'=>2
        ]);

        $table->changeColumn('saldo_anterior', 'decimal', [
            'null' => false,
            'default' => 0,
            'precision'=> 10,
            'scale'=>2
        ]);

        $table->changeColumn('saldo', 'decimal', [
            'null' => false,
            'default' => 0,
            'precision'=> 10,
            'scale'=>2
        ]);
    }
}
