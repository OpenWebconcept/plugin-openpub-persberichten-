<?php

namespace OWC\Persberichten\Settings;

use OWC\Persberichten\Traits\CheckPluginActive;

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
    public function getPortalURL(): string
    {
        return $this->settings['_owc_setting_portal_url'] ?? '';
    }

    public function getPortalItemSlug(): string
    {
        return $this->settings['_owc_setting_portal_press_release_item_slug'] ?? '';
    }

    public function getOrganisationName(): string
    {
        return $this->settings['_owc_setting_press_release_organisation_account'] ?? '';
    }

    public function getOrganisationEmail(): string
    {
        return $this->settings['_owc_setting_press_release_account_email'] ?? '';
    }

    public function getReplyToEmail(): string
    {
        return $this->settings['_owc_setting_press_reply_to_email'] ?? '';
    }

    public function getApiKey(): string
    {
        return $this->settings['_owc_setting_press_release_api_key'] ?? '';
    }

    public function getApiURL(): string
    {
        return $this->settings['_owc_setting_press_release_api_url'] ?? '';
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
            '_owc_setting_portal_url'                           => '',
            '_owc_setting_portal_press_release_item_slug'       => '',
            '_owc_setting_press_release_organisation_account'   => '',
            '_owc_setting_press_release_account_email'          => '',
            '_owc_setting_press_reply_to_email'                 => '',
            '_owc_setting_press_release_api_key'                => '',
            '_owc_setting_press_release_api_url'                => '',
            '_owc_setting_additional_message'                   => '',
        ];

        $options = get_option('_owc_press_settings', []);

        if (CheckPluginActive::isPluginOpenPubBaseActive()) {
            // include openpub-base settings.
            $options = array_merge($options, get_option('_owc_openpub_base_settings', []));
        };

        return new static(wp_parse_args($options, $defaultSettings));
    }
}
