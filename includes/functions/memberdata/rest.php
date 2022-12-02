<?php

/**
 * Get /member/
 */
add_action('rest_api_init', function () {
    /**
     * GET /member/{id}
     * @param int $id Member ID.
     * @param int $bitwise Bitwise (optional).
     * @return object Member data.
     * @since hk15
     */
    register_rest_route('v2', '/member/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function($arguments) {
            wp_send_json(YipnyapGetMember($arguments['id']));
        },
    ));

    register_rest_route('v2', '/member/(?P<id>\d+)/(?P<bitwise>\d+)', array(
        'methods' => 'GET',
        'callback' => function($arguments) {
            wp_send_json(YipnyapGetMember($arguments['id'], $arguments['bitwise']));
        },
    ));
});

/**
 * Get /bitwise
 */
add_action('rest_api_init', function () {
    /**
     * GET /bitwise
     * @return object Bitwise values.
     * @since hk15
     */
    register_rest_route('v2', '/bitwise', array(
        'methods' => 'GET',
        'callback' => function() {
            wp_send_json(YipnyapGetBitwiseValues());
        },
    ));
});

// TODO: Move to a separate file.
add_action('rest_api_init', function () {
    /**
     * GET /
     * @return object API metadata.
     * @since hk15
     */
    add_filter('rest_index', function ($response){
        $data = [
            'version' => 'v2',
            'notices' => [
                '2-12-2022' => 'This API is still in development.'
            ],
        ];

        $response->set_data($data);

        return $response;
    });
});
