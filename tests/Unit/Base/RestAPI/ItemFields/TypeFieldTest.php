<?php

namespace OWC\Persberichten\Tests\Base\RestAPI\ItemFields;

use Mockery as m;
use OWC\Persberichten\Foundation\Config;
use OWC\Persberichten\Foundation\Loader;
use OWC\Persberichten\Models\Persbericht;
use OWC\Persberichten\Foundation\Plugin;
use OWC\Persberichten\RestAPI\ItemFields\TypeField;
use OWC\Persberichten\Tests\TestCase;
use WP_Mock;
use WP_Post;

class TypeFieldTest extends TestCase
{
    protected $post;

    protected $plugin;

    protected function setUp(): void
    {
        WP_Mock::setUp();

        $config       = m::mock(Config::class);
        $this->plugin = m::mock(Plugin::class);

        $this->plugin->config = $config;
        $this->plugin->loader = m::mock(Loader::class);

        $this->post     = m::mock(WP_Post::class);
        $this->post->ID = 1;
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function press_release_does_not_have_terms()
    {
        $typeField = new TypeField($this->plugin);

        $this->post->shouldReceive('to_array')->andReturn(['ID' => 1]);
        WP_Mock::userFunction(
            'get_the_terms',
            []
        );

        $actual       = $typeField->create($this->post);
        $expected     = [];

        $this->assertEquals($expected, $actual);
    }
}
