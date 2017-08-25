<?php
use Migrations\AbstractMigration;

class CreateMovimientosCaja extends AbstractMigration
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
        $table->addColumn('fecha', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('usuario_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('descripcion', 'string', [
            'default' => '',
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('tipo_movimiento', 'string', [
            'default' => '',
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('cantidad', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('cantidad_existente', 'float', [
            'default' =>0,
            'null' => false,
        ]);

        $table->create();
    }
}
