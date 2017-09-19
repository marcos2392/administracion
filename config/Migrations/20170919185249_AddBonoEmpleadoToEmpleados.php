<?php
use Migrations\AbstractMigration;

class AddBonoEmpleadoToEmpleados extends AbstractMigration
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
        $table = $this->table('empleados');
        $table->addColumn('bono', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
