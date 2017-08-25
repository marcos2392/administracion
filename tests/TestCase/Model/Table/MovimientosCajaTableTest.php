<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimientosCajaTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimientosCajaTable Test Case
 */
class MovimientosCajaTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimientosCajaTable
     */
    public $MovimientosCaja;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.movimientos_caja',
        'app.usuarios'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MovimientosCaja') ? [] : ['className' => 'App\Model\Table\MovimientosCajaTable'];
        $this->MovimientosCaja = TableRegistry::get('MovimientosCaja', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimientosCaja);

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
