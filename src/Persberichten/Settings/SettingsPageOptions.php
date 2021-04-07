<?php

namespace OWC\OpenPub\Persberichten\Settings;

class SettingsPageOptions
{
    /**
     * Settings defined on settings page
     *
     * @var array
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * URL to the portal website.
     *
     * @return string
     */
    public function getAdditionalMessage(): string
    {
        return $this->settings['_owc_setting_additional_message'] ?? '';
    }

    public static function make(): self
    {
        $defaultSettings = [
            '_owc_setting_additional_message' => '',
        ];

        return new static(wp_parse_args(get_option('_owc_openpub_press_settings'), $defaultSettings));
    }
}
