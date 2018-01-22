<?php
use Migrations\AbstractMigration;

class CreateProveedoresNotasPagadas extends AbstractMigration
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
        $table = $this->table('proveedores_notas_pagadas');
        $table->addColumn('fecha', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('usuario_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('proveedor_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('descripcion', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('cantidad', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('nota_proveedor_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->create();
    }
}
