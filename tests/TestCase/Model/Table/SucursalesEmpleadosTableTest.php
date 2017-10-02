<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SucursalesEmpleadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SucursalesEmpleadosTable Test Case
 */
class SucursalesEmpleadosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SucursalesEmpleadosTable
     */
    public $SucursalesEmpleados;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sucursales_empleados',
        'app.empleados',
        'app.sucursales',
        'app.sucursales'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SucursalesEmpleados') ? [] : ['className' => 'App\Model\Table\SucursalesEmpleadosTable'];
        $this->SucursalesEmpleados = TableRegistry::get('SucursalesEmpleados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SucursalesEmpleados);

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
