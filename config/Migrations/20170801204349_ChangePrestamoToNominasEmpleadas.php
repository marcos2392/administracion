<?php
use Migrations\AbstractMigration;

class ChangePrestamoToNominasEmpleadas extends AbstractMigration
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
        $table->changeColumn('prestamo', 'float', [
            'null' => false,
            'default' => 0
        ]);
    }
}
