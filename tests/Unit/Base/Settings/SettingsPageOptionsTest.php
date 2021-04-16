<?php

namespace OWC\PDC\Tests\Base\Settings;

use OWC\OpenPub\Persberichten\Settings\SettingsPageOptions;
use OWC\OpenPub\Persberichten\Tests\TestCase;

class SettingsPageOptionsTest extends TestCase
{
    /** @var SettingsPageOptions */
    private $settingsPageOptions;

    public function setUp(): void
    {
        \WP_Mock::setUp();

        $this->settingsPageOptions = new SettingsPageOptions([
            '_owc_setting_portal_url'               => 'https://www.test.nl',
            '_owc_setting_portal_openpub_item_slug' => 'persbericht',
            '_owc_setting_additional_message'       => 'Extra bericht',
        ]);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function portal_url_has_value(): void
    {
        $expectedResult = 'https://www.test.nl';
        $result         = $this->settingsPageOptions->getPortalURL();

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_url_has_no_value(): void
    {
        $expectedResult = '';
        $result         = $this->settingsPageOptions->getPortalURL();

        $this->assertNotEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_item_slug_has_value(): void
    {
        $expectedResult = 'persbericht';
        $result         = $this->settingsPageOptions->getPortalItemSlug();

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function portal_item_slug_has_no_value(): void
    {
        $expectedResult = '';
        $result         = $this->settingsPageOptions->getPortalItemSlug();

        $this->assertNotEquals($expectedResult, $result);
    }

    /** @test */
    public function setting_additional_message_is_the_same(): void
    {
        $expectedResult = 'Extra bericht';
        $result         = $this->settingsPageOptions->getAdditionalMessage();

        $this->assertEquals($expectedResult, $result);
    }
}
