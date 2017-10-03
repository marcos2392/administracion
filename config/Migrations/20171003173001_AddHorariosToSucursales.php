<?php
use Migrations\AbstractMigration;

class AddHorariosToSucursales extends AbstractMigration
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
        $table = $this->table('sucursales');
        $table->addColumn('hora_entrada', 'time', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('hora_salida', 'time', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
