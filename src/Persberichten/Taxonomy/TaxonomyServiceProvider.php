<?php

namespace OWC\OpenPub\Persberichten\Taxonomy;

use OWC\OpenPub\Persberichten\Foundation\ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider
{
    /**
     * the array of taxonomies definitions from the config
     *
     * @var array
     */
    protected $configTaxonomies = [];

    /**
     * @return void
     */
    public function register(): void
    {
        $taxonomyController = new TaxonomyController();

        $this->plugin->loader->addAction('init', $this, 'registerTaxonomies');
        $this->plugin->loader->addAction('openpub_press_mailing_list_add_form_fields', $taxonomyController, 'addMailingListField');
        $this->plugin->loader->addAction('openpub_press_mailing_list_edit_form_fields', $taxonomyController, 'editMailingListField', 10, 2);
        $this->plugin->loader->addFilter('manage_edit-openpub_press_mailing_list_columns', $taxonomyController, 'mailingListAdminColumnHeader');
        $this->plugin->loader->addFilter('manage_openpub_press_mailing_list_custom_column', $taxonomyController, 'mailingListAdminColumnValue', 10, 3);
        $this->plugin->loader->addAction('created_openpub_press_mailing_list', $taxonomyController, 'saveMailingListField');
        $this->plugin->loader->addAction('edited_openpub_press_mailing_list', $taxonomyController, 'saveMailingListField');
    }

    /**
     * Register custom taxonomies via extended_cpts
     *
     * @return void
     */
    public function registerTaxonomies(): void
    {
        if (function_exists('register_extended_taxonomy')) {
            $this->configTaxonomies = $this->plugin->config->get('taxonomies');
            foreach ($this->configTaxonomies as $taxonomyName => $taxonomy) {
                // Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
                register_extended_taxonomy($taxonomyName, $taxonomy['object_types'], $taxonomy['args'], $taxonomy['names']);
            }
        }
    }
}
