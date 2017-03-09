<?php
namespace Seo\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Seo\Model\Table\SeoCanonicalsTable;

/**
 * Seo\Model\Table\SeoCanonicalsTable Test Case
 */
class SeoCanonicalsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.seo.seo_canonicals',
        'plugin.seo.seo_uris',
        'plugin.seo.seo_meta_tags',
        'plugin.seo.seo_titles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SeoCanonicals') ? [] : ['className' => 'Seo\Model\Table\SeoCanonicalsTable'];
        $this->SeoCanonicals = TableRegistry::get('SeoCanonicals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SeoCanonicals);

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
