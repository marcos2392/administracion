<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NominaEmpleadasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NominaEmpleadasTable Test Case
 */
class NominaEmpleadasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NominaEmpleadasTable
     */
    public $NominaEmpleadas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.nomina_empleadas',
        'app.empleados',
        'app.sucursales',
        'app.sucursals'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NominaEmpleadas') ? [] : ['className' => 'App\Model\Table\NominaEmpleadasTable'];
        $this->NominaEmpleadas = TableRegistry::get('NominaEmpleadas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NominaEmpleadas);

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
