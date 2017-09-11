<?php
use Migrations\AbstractMigration;

class CreateReparaciones extends AbstractMigration
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
        $table = $this->table('reparaciones');
        $table->addColumn('fecha', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('usuario_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('joyero_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('sucursal_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('cantidad', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
