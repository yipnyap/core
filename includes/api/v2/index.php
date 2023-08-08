<?php
add_action('rest_api_init', function () {
    /**
     * GET /
     *
     * @return object API metadata.
     * @since hk15
     */
    add_filter('rest_index', function ($response) {
        $data = [
            'version' => 'v2',
            'notices' => [
                '2-12-2022' => 'This API is still in development.',
            ],
        ];

        $response->set_data($data);

        return $response;
    });

    /**
     * GET /nonce
     *
     * @return object API nonce.
     * @since ui3
     */
    register_rest_route('v2', '/nonce', [
        'methods' => 'GET',
        'callback' => function () {
            return wp_create_nonce('wp_rest');
        },
    ]);
});

require_once __DIR__ . '/comic.php';
require_once __DIR__ . '/member.php';
require_once __DIR__ . '/notifications.php';
require_once __DIR__ . '/relationships.php';
require_once __DIR__ . '/telegram.php';
require_once __DIR__ . '/dipswitch.php';
require_once __DIR__ . '/Groups_Rest_Endpoint.php';
require_once __DIR__ . '/AllocatedStorage_Rest_Endpoint.php';
require_once __DIR__ . '/Feed_Rest_Endpoint.php';

use Yipnyap\AllocatedStorage_Rest_Endpoint;
use Yipnyap\Groups_Rest_Endpoint;
use Yipnyap\Feed_Rest_Endpoint;

add_action('rest_api_init', function () {
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
    add_filter('rest_pre_serve_request', function($value) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Expose-Headers: Link', false);
        header('Access-Control-Allow-Headers: X-Requested-With');

        return $value;
    });

    $groups = new Groups_Rest_Endpoint();
    $groups->register();

    $storage = new AllocatedStorage_Rest_Endpoint();
    $storage->register();

    $feed = new Feed_Rest_Endpoint();
    $feed->register();
}, 15);
