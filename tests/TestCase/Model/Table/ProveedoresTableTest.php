<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProveedoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProveedoresTable Test Case
 */
class ProveedoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProveedoresTable
     */
    public $Proveedores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('Proveedores') ? [] : ['className' => 'App\Model\Table\ProveedoresTable'];
        $this->Proveedores = TableRegistry::get('Proveedores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Proveedores);

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
