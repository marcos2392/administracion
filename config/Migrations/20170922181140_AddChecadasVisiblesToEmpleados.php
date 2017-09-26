<?php
use Migrations\AbstractMigration;

class AddChecadasVisiblesToEmpleados extends AbstractMigration
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
        $table->addColumn('checada_visible', 'boolean', [
            'default' => 1,
            'null' => false,
        ]);
        $table->update();
    }
}
