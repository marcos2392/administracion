<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimientosProveedoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimientosProveedoresTable Test Case
 */
class MovimientosProveedoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimientosProveedoresTable
     */
    public $MovimientosProveedores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.movimientos_proveedores',
        'app.usuarios',
        'app.proveedores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MovimientosProveedores') ? [] : ['className' => 'App\Model\Table\MovimientosProveedoresTable'];
        $this->MovimientosProveedores = TableRegistry::get('MovimientosProveedores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimientosProveedores);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
