<?php
use Migrations\AbstractMigration;

class AddHorarioMixtoToSucursales extends AbstractMigration
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
        $table->addColumn('horario_libre', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->update();
    }
}
