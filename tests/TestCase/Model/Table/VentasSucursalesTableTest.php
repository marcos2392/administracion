<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VentasSucursalesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VentasSucursalesTable Test Case
 */
class VentasSucursalesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VentasSucursalesTable
     */
    public $VentasSucursales;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ventas_sucursales'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('VentasSucursales') ? [] : ['className' => 'App\Model\Table\VentasSucursalesTable'];
        $this->VentasSucursales = TableRegistry::get('VentasSucursales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VentasSucursales);

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
}
