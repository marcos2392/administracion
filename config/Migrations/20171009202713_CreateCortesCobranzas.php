<?php
use Migrations\AbstractMigration;

class CreateCortesCobranzas extends AbstractMigration
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
        $table = $this->table('cortes_cobranzas');
        $table->addColumn('corte_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('cobranza_cobrador_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('cantidad', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('comision', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('porcentaje_comision', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->create();
    }
}
