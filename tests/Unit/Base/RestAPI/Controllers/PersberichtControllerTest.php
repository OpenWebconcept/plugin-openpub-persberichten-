<?php

namespace OWC\OpenPub\Persberichten\Tests\Base\RestAPI\Controllers;

use OWC\OpenPub\Persberichten\Repositories\Persbericht;
use OWC\OpenPub\Persberichten\Tests\TestCase;
use WP_Mock;

class PersberichtControllerTest extends TestCase
{
    protected function setUp(): void
    {
        WP_Mock::setUp();
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
    }

    /** @test */
    public function add_tax_query_to_wp_query()
    {
        $expected = [
            'tax_query' => [
                [
                    'taxonomy' => 'openpub-press-mailing-list',
                    'terms'    => 'test',
                    'field'    => 'slug'
                ]
            ]
        ];

        $actual = Persbericht::addFilterTypeParameters('test');

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function add_tax_query_to_wp_query_returns_empty_array()
    {
        $expected = [
            'tax_query' => [
                [
                    'taxonomy' => 'openpub-press-mailing-list',
                    'terms'    => 'test',
                    'field'    => 'slug'
                ]
            ]
        ];

        $actual = Persbericht::addFilterTypeParameters();

        $this->assertNotEquals($expected, $actual);
    }
}
