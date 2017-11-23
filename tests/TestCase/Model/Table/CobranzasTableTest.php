<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CobranzasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CobranzasTable Test Case
 */
class CobranzasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CobranzasTable
     */
    public $Cobranzas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cobranzas',
        'app.cobradores',
        'app.cobranzas_cobradores',
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
        $config = TableRegistry::exists('Cobranzas') ? [] : ['className' => 'App\Model\Table\CobranzasTable'];
        $this->Cobranzas = TableRegistry::get('Cobranzas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cobranzas);

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
