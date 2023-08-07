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

        register_rest_route($this->namespace, $this->rest_base . '/post/(?P<id>[a-zA-Z0-9-]+)/like', [
            [
                'methods' => ['PUT', 'DELETE'],
                'callback' => [$this, 'edit_like_item'],
                'args' => [
                    'id' => [
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
        $FeedTarget = $request->get_param('feed');
        $UserTarget = $request->get_param('user');
        $GroupTarget = $request->get_param('group');
        if (!empty($FeedTarget) || !empty($UserTarget) || !empty($GroupTarget)) {
            $Target = $FeedTarget ?? $UserTarget ?? $GroupTarget;
            // If UserTarget or GroupTarget is set, its an override
            $TargetOverride = false;
            if (!empty($UserTarget)) {
                $TargetOverride = 'User';
            } elseif (!empty($GroupTarget)) {
                $TargetOverride = 'Group';
            }

            $FeedMix = new FeedMixer($Target, false, $TargetOverride);
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
        if (!is_user_logged_in()) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'You must be logged in to post.',
            ], 401);
        }

        $FeedMix = new FeedMixer();
        $post = $FeedMix->CreatePost([
            'content' => $request->get_param('content'),
            'tags' => $request->get_param('tags'),
            'objects' => $request->get_param('objects'),
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
        if (!is_user_logged_in()) {
            return new WP_REST_Response([
                'success' => false,
                'message' => 'You must be logged in to comment.',
            ], 401);
        }

        $comment = FeedMixer::CreateComment($request->get_param('id'), $request->get_param('content'), $request->get_param('parent'));

        $response = new WP_REST_Response($comment);

        if ($comment['success']) {
            $response->set_status(200);
        } else {
            $response->set_status(400);
        }

        $response->header('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Add/remove a like
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response
     * @throws Exception
     * @since ui3
     * @access public
     */
    public function edit_like_item(WP_REST_Request $request): WP_REST_Response
    {
        // check if 'PUT' or 'DELETE'
        $like = FeedMixer::EditLike($request->get_param('id'), $request->get_method() == 'PUT' ? 'ADDITION' : 'DELETION');

        $response = new WP_REST_Response($like);

        if ($like['success']) {
            $response->set_status(200);
        } else {
            $response->set_status(400);
        }

        $response->header('Content-Type', 'application/json');

        return $response;
    }

}