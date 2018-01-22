<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProveedoresNotasPagadasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProveedoresNotasPagadasTable Test Case
 */
class ProveedoresNotasPagadasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProveedoresNotasPagadasTable
     */
    public $ProveedoresNotasPagadas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.proveedores_notas_pagadas',
        'app.usuarios',
        'app.proveedores',
        'app.nota_proveedores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProveedoresNotasPagadas') ? [] : ['className' => 'App\Model\Table\ProveedoresNotasPagadasTable'];
        $this->ProveedoresNotasPagadas = TableRegistry::get('ProveedoresNotasPagadas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProveedoresNotasPagadas);

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
