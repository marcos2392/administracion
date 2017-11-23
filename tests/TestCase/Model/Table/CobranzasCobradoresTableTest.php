<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CobranzasCobradoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CobranzasCobradoresTable Test Case
 */
class CobranzasCobradoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CobranzasCobradoresTable
     */
    public $CobranzasCobradores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cobranzas_cobradores',
        'app.cobradores',
        'app.cobranzas',
        'app.cortes',
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
        $config = TableRegistry::exists('CobranzasCobradores') ? [] : ['className' => 'App\Model\Table\CobranzasCobradoresTable'];
        $this->CobranzasCobradores = TableRegistry::get('CobranzasCobradores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CobranzasCobradores);

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
