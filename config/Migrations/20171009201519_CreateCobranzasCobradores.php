<?php
use Migrations\AbstractMigration;

class CreateCobranzasCobradores extends AbstractMigration
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
        $table = $this->table('cobranzas_cobradores');
        $table->addColumn('cobrador_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('cobranza_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('porcentaje_comision', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
