<?php

namespace OWC\Persberichten\Settings;

use OWC\Persberichten\Metabox\MetaboxBaseServiceProvider;
use OWC\Persberichten\Traits\CheckPluginActive;

class SettingsServiceProvider extends MetaboxBaseServiceProvider
{
	use CheckPluginActive;

    const PREFIX = '_owc_';

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->plugin->loader->addFilter('mb_settings_pages', $this, 'registerSettingsPage', 10, 1);
        $this->plugin->loader->addFilter('rwmb_meta_boxes', $this, 'registerSettings', 10, 1);
    }

    public function registerSettingsPage($rwmbSettingsPages): array
    {
        $settingsPages = $this->plugin->config->get('settings_pages');

        if (!static::isPluginOpenPubBaseActive()) {
            // unset the parent of the setting page.
            unset($settingsPages['pressreleases']['parent']);
        }

        return array_merge($rwmbSettingsPages, $settingsPages);
    }

    /**
     * Register metaboxes for settings page.
     */
    public function registerSettings($rwmbMetaboxes): array
    {
        $configMetaboxes = $this->plugin->config->get('settings');
        $metaboxes       = [];

        if (static::isPluginOpenPubBaseActive()) {
            // unset setting because it is already defined in the openpub base plugin.
            unset($configMetaboxes['pressreleases']['fields']['settings']['settings_press_release_portal_url']);
        }

        foreach ($configMetaboxes as $metabox) {
            $metaboxes[] = $this->processMetabox($metabox);
        }

        return array_merge($rwmbMetaboxes, $metaboxes);
    }
}
