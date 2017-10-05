<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CobradoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CobradoresTable Test Case
 */
class CobradoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CobradoresTable
     */
    public $Cobradores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cobradores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cobradores') ? [] : ['className' => 'App\Model\Table\CobradoresTable'];
        $this->Cobradores = TableRegistry::get('Cobradores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cobradores);

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
