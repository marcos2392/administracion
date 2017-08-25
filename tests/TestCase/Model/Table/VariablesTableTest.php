<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VariablesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VariablesTable Test Case
 */
class VariablesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VariablesTable
     */
    public $Variables;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.variables'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Variables') ? [] : ['className' => 'App\Model\Table\VariablesTable'];
        $this->Variables = TableRegistry::get('Variables', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Variables);

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
