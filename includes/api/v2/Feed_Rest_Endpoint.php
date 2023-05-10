<?php
namespace Yipnyap;

require_once YIPNYAP_PATH . '/includes/functions/nextgen/FeedMixer/FeedMixer.php';

use Exception;
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
        register_rest_route($this->namespace, $this->rest_base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_items'],
                'args' => $this->get_collection_params(),
            ],
            'schema' => [$this, 'get_public_item_schema'],
        ]);

        register_rest_route($this->namespace, $this->rest_base . '/post', [
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'edit_item'],
                'args' => [
                    'content' => [
                        'type' => 'object',
                        'required' => true,
                    ],
                ]
            ],
            'schema' => [$this, 'edit_public_item_schema'],
        ]);

        register_rest_route($this->namespace, $this->rest_base . '/post/(?P<id>[a-zA-Z0-9-]+)/comment', [
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'edit_comment_item'],
                'args' => [
                    'content' => [
                        'type' => 'string',
                        'required' => true,
                    ],
                ]
            ],
            'schema' => [$this, 'edit_public_item_schema'],
        ]);
    }

    /**
     * Get the guest mix feed (OR the user's feed if logged in & 'user' matches)
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response
     * @throws Exception
     * @see WP_REST_Controller::get_items()
     * @see FeedMixer->MixGuestFeed()
     * @since ui3
     * @access public
     */
    public function get_items($request): WP_REST_Response
    {
        $FeedTarget = $request->get_param('user');
        if (!empty($FeedTarget) && $FeedTarget == YipnyapGetMemberE2ID($FeedTarget) /* @todo: feed sharing? */) {
            $FeedMix = new FeedMixer($FeedTarget);
            $feed = $FeedMix->MixFeed($request->get_param('page'));
        } else {
            // Guest
            $feed = FeedMixer::MixGuestFeed($request->get_param('page'));
        }

        // just testing
//        $feed = SupabaseUserContentUpload('01A1TESTINGSERVICE', YIPNYAP_PATH . '/img/yipnyap-logo.png', '03A1TESTPOST');

        $response = new WP_REST_Response($feed);
        $response->set_status(200);
        $response->header('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Create or edit a post
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response
     * @throws Exception
     * @see WP_REST_Controller::edit_item()
     * @since ui3
     * @access public
     */
    public function edit_item(WP_REST_Request $request): WP_REST_Response {
        $FeedMix = new FeedMixer();
        $post = $FeedMix->CreatePost([
            'content' => $request->get_param('content'),
            'tags' => $request->get_param('tags'),
        ]);

        $response = new WP_REST_Response($post);
        $response->set_status(200);
        $response->header('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Create or edit a comment
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response
     * @throws Exception
     * @since ui3
     * @access public
     */
    public function edit_comment_item(WP_REST_Request $request): WP_REST_Response {
        $comment = FeedMixer::CreateComment($request->get_param('id'), $request->get_param('content'));

        $response = new WP_REST_Response($comment);
        $response->set_status(200);
        $response->header('Content-Type', 'application/json');

        return $response;
    }

}