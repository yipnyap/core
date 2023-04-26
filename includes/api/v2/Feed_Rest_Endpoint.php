<?php
namespace Yipnyap;

require_once YIPNYAP_PATH . '/includes/functions/nextgen/FeedMixer/FeedMixer.php';

use Yipnyap\FeedMixer;
use WP_Error;
use WP_Http;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * Feed REST Endpoint
 *
 * @package    Yipnyap
 * @subpackage Feed
 * @since      ui3
 * @version    ui3
 * @access     public
 */
class Feed_Rest_Endpoint extends WP_REST_Controller {
    /**
     * Constructor.
     *
     * @since ui2
     */
    public function __construct() {
        $this->namespace = 'v2';
        $this->rest_base = '/feed';
    }

    /**
     * Registers the routes for the objects of the controller.
     *
     * @since ui2
     *
     * @see register_rest_route()
     */
    public function register(): void {
        register_rest_route($this->namespace, $this->rest_base . '/guest', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_items'],
                'args' => $this->get_collection_params(),
            ],
            'schema' => [$this, 'get_public_item_schema'],
        ]);
    }

    /**
     * Get the guest mix feed
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response
     * @since ui3
     * @access public
     * @see WP_REST_Controller::get_items()
     * @see FeedMixer->MixGuestFeed()
     */
    public function get_items($request): WP_REST_Response
    {
        $FeedMix = new FeedMixer();
        $feed = $FeedMix->MixGuestFeed();

        $response = new WP_REST_Response($feed);
        $response->set_status(200);
        $response->header('Content-Type', 'application/json');

        return $response;
    }

}