<?php

namespace OWC\Persberichten\Laposta;

use OWC\Persberichten\Foundation\ServiceProvider;

class LapostaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->plugin->loader->addAction('rest_after_insert_openpub-press-item', new LapostaController($this->plugin), 'handleSave', 10, 3);
    }
}
