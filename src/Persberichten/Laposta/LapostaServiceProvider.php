<?php

namespace OWC\OpenPub\Persberichten\Laposta;

use OWC\OpenPub\Persberichten\Foundation\ServiceProvider;

class LapostaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->plugin->loader->addAction('wp_insert_post', new LapostaController(), 'handleSave', 10, 3);
    }
}
