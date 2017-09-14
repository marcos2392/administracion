<?php
use Migrations\AbstractMigration;

class AddCantidadAnteriorToMovimientosCaja extends AbstractMigration
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
        $table->addColumn('cantidad_existente_anterior', 'decimal', [
            'null' => false,
            'default' => 0,
            'precision'=> 10,
            'scale'=>2
        ]);

        $table->changeColumn('cantidad', 'decimal', [
            'null' => false,
            'default' => 0,
            'precision'=> 10,
            'scale'=>2
        ]);

        $table->changeColumn('cantidad_existente', 'decimal', [
            'null' => false,
            'default' => 0,
            'precision'=> 10,
            'scale'=>2
        ]);

        $table->update();
    }
}
