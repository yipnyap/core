<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace Yipnyap;

require_once YIPNYAP_PATH . '/includes/functions/nextgen/Search.php';

use Exception;
use WP_Error;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class Search_Endpoint extends WP_REST_Controller
{
    protected $namespace = 'v2';
    protected $rest_base = '/search';

    /**
     * Constructor.
     *
     * @since ui3-2
     */
    public function __construct() {}

    /**
     * Registers the routes for the objects of the controller.
     *
     * @since ui3-2
     *
     * @see register_rest_route()
     */
    public function register(): void
    {
        register_rest_route($this->namespace, $this->rest_base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_items'],
                'args' => $this->get_collection_params(),
            ],
            'schema' => [$this, 'get_public_item_schema'],
        ]);
    }

    /**
     * Retrieves a collection of items.
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     *
     * @throws Exception
     * @since ui3-2
     */
    public function get_items($request): WP_REST_Response|WP_Error
    {
        $startTime = microtime(true);

        $search = new Search($request['exclude'] ?? []);
        $search->search($request['q']);

        $endTime = microtime(true);
        $search->results['time'] = $endTime - $startTime;
        $search->results['time'] = round($search->results['time'] * 1000, 3);

        return new WP_REST_Response($search->results, 200);
    }

    /**
     * Retrieves the query params for collections.
     *
     * @return array Collection parameters.
     *
     * @since ui3-2
     */
    public function get_collection_params(): array
    {
        return [
            'q' => [
                'description' => __('Search query.'),
                'type' => 'string',
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => 'rest_validate_request_arg',
            ],
            'exclude' => [
                'description' => __('Exclude these tables from the search.'),
                'type' => 'array',
                'required' => false,
                'sanitize_callback' => 'rest_sanitize_request_arg',
                'validate_callback' => 'rest_validate_request_arg',
            ],
        ];
    }
}