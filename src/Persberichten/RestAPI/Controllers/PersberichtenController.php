<?php

namespace OWC\OpenPub\Persberichten\RestAPI\Controllers;

use OWC\OpenPub\Persberichten\Repositories\Persbericht;
use WP_Error;
use WP_Post;
use WP_Query;
use WP_REST_Request;

class PersberichtenController extends BaseController
{
    public function getItems(WP_REST_Request $request)
    {
        $items = (new Persbericht($this->plugin))
            ->query($this->getPaginatorParams($request));

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    public function getTypeFilteredItems(WP_REST_Request $request)
    {
        $items = (new Persbericht($this->plugin))
            ->query($this->getPaginatorParams($request))
            ->query(Persbericht::addFilterTypeParameters($request->get_param('type')));

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }
}
