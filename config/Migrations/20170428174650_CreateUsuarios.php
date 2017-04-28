<?php
use Migrations\AbstractMigration;

class CreateUsuarios extends AbstractMigration
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
        $table = $this->table('usuarios');
        $table->addColumn('nombre', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('usuario', 'string', [
            'null' => false,
        ]);
        $table->addColumn('password', 'string', [
            'null' => false,
        ]);
        $table->addColumn('admin', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('activo', 'boolean', [
            'default' => true,
            'null' => false,
        ]);
        
        
        $table->create();
    }
}
