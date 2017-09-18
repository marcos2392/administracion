<?php
use Migrations\AbstractMigration;

class ChangeValoresToNominaEmpleadas extends AbstractMigration
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
        $table->changeColumn('horas', 'float', [
            'null' => false,
            'default' => 0
        ]);

        $table->changeColumn('sueldo', 'float', [
            'null' => false,
            'default' => 0
        ]);

        $table->changeColumn('infonavit', 'float', [
            'null' => false,
            'default' => 0
        ]);

        $table->changeColumn('bono', 'float', [
            'null' => false,
            'default' => 0
        ]);

        $table->changeColumn('comision', 'float', [
            'null' => false,
            'default' => 0
        ]);

        $table->changeColumn('joyeria', 'float', [
            'null' => false,
            'default' => 0
        ]);

        $table->changeColumn('sueldo_final', 'float', [
            'null' => false,
            'default' => 0
        ]);
    }
}
