<?php
use Migrations\AbstractMigration;

class ChangeSaldoToSaldoProveedores extends AbstractMigration
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
        $table->changeColumn('saldo', 'decimal', [
            'null' => false,
            'default' => 0,
            'precision'=> 10,
            'scale'=>2
        ]);
    }
}
