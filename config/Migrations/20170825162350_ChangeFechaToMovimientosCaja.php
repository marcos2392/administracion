<?php
use Migrations\AbstractMigration;

class ChangeFechaToMovimientosCaja extends AbstractMigration
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
        $table = $this->table('movimientos_caja');
        $table->changeColumn('fecha', 'datetime', [
            'null' => false,
            'default' => 0
        ]);
    }
}
