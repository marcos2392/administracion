<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CortesCobranzasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CortesCobranzasTable Test Case
 */
class CortesCobranzasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CortesCobranzasTable
     */
    public $CortesCobranzas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cortes_cobranzas',
        'app.cortes',
        'app.cobradores',
        'app.cobranzas',
        'app.cobranzas_cobradores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CortesCobranzas') ? [] : ['className' => 'App\Model\Table\CortesCobranzasTable'];
        $this->CortesCobranzas = TableRegistry::get('CortesCobranzas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CortesCobranzas);

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
