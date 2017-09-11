<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JoyerosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JoyerosTable Test Case
 */
class JoyerosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\JoyerosTable
     */
    public $Joyeros;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.joyeros'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Joyeros') ? [] : ['className' => 'App\Model\Table\JoyerosTable'];
        $this->Joyeros = TableRegistry::get('Joyeros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Joyeros);

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
