<?php
use Migrations\AbstractMigration;

class AddAhorroCantidadToNominaEmpleadas extends AbstractMigration
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
        $table = $this->table('nomina_empleadas');
        $table->addColumn('ahorro_cantidad', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
