<?php

namespace OWC\Persberichten\Tests\Persberichten\PostType;

use Mockery as m;
use OWC\Persberichten\Foundation\Config;
use OWC\Persberichten\Foundation\Loader;
use OWC\Persberichten\Foundation\Plugin;
use OWC\Persberichten\PostType\PostTypeServiceProvider;
use OWC\Persberichten\Tests\TestCase;
use WP_Mock;

class PostTypeServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url'                     => '',
                '_owc_setting_portal_openpub_item_slug'       => '',
                '_owc_setting_use_portal_url'                 => 0,
                '_owc_setting_use_escape_element'             => 0,
                '_owc_setting_portal_press_release_item_slug' => '',
                '_owc_setting_additional_message'             => ''
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                     => '',
                '_owc_setting_portal_openpub_item_slug'       => '',
                '_owc_setting_use_portal_url'                 => 0,
                '_owc_setting_use_escape_element'             => 0,
                '_owc_setting_portal_press_release_item_slug' => '',
                '_owc_setting_additional_message'             => ''
            ]
        ]);
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_posttypes()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        // use function is_plugin_active
        \WP_Mock::userFunction('is_plugin_active', [
            'return' => true
        ]);

        $service = new PostTypeServiceProvider($plugin);

        $this->post     = m::mock(WP_Post::class);
        $this->post->ID = 1;

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'init',
            $service,
            'registerPostTypes',
        ])->once();

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'pre_get_posts',
            $service,
            'orderByPublishedDate',
        ])->once();

        $service->register();

        $this->assertTrue(true);
    }
}
