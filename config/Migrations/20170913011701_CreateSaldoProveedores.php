<?php
use Migrations\AbstractMigration;

class CreateSaldoProveedores extends AbstractMigration
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
        $table = $this->table('saldo_proveedores');
        $table->addColumn('proveedor_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('saldo', 'string', [
            'default' => 0,
            'limit' => 255,
            'null' => false,
        ]);
        $table->create();
    }
}
