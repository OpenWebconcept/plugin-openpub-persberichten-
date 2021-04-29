<?php

namespace OWC\Persberichten\Laposta;

use OWC\Persberichten\Foundation\ServiceProvider;

class LapostaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->plugin->loader->addAction('rest_after_insert_press-item', new LapostaController($this->plugin, new LapostaRequest($this->plugin->settings)), 'handleSave', 10, 3);
    }
}
