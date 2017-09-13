<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SaldoProveedoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SaldoProveedoresTable Test Case
 */
class SaldoProveedoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SaldoProveedoresTable
     */
    public $SaldoProveedores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.saldo_proveedores',
        'app.proveedors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SaldoProveedores') ? [] : ['className' => 'App\Model\Table\SaldoProveedoresTable'];
        $this->SaldoProveedores = TableRegistry::get('SaldoProveedores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SaldoProveedores);

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
