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

    /**
     * Get an individual post item.
     *
     * @param WP_REST_Request $request $request
     *
     * @return array|WP_Error
     * @throws \OWC\OpenPub\Base\Exceptions\PropertyNotExistsException
     * @throws \ReflectionException
     */
    public function getItem(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');

        $item = (new Persbericht($this->plugin))
            ->find($id);

        if (!$item) {
            return new WP_Error('no_item_found', sprintf('Item with ID "%d" not found (anymore)', $id), [
                'status' => 404,
            ]);
        }

        return $item;
    }

    /**
     * Get an individual post item by slug.
     *
     * @param $request $request
     *
     * @return array|WP_Error
     */
    public function getItemBySlug(WP_REST_Request $request)
    {
        $slug = $request->get_param('slug');

        $item = (new Persbericht($this->plugin))
            ->findBySlug($slug);

        if (!$item) {
            return new WP_Error('no_item_found', sprintf('Item with slug "%s" not found', $slug), [
                'status' => 404,
            ]);
        }

        return $item;
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
