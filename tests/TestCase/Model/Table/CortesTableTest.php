<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CortesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CortesTable Test Case
 */
class CortesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CortesTable
     */
    public $Cortes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cortes',
        'app.cobradores',
        'app.cobranzas',
        'app.cobranzas_cobradores',
        'app.cortes_cobranzas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cortes') ? [] : ['className' => 'App\Model\Table\CortesTable'];
        $this->Cortes = TableRegistry::get('Cortes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cortes);

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
