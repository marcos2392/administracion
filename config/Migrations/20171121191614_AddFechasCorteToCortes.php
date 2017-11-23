<?php
use Migrations\AbstractMigration;

class AddFechasCorteToCortes extends AbstractMigration
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
        $table = $this->table('cortes');
        $table->addColumn('fecha_inicio', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('fecha_termino', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
