<?php
/**
 * /member/
 */
add_action('rest_api_init', function () {
    /**
     * GET /member/{id}/badges
     * @param int $id Member ID.
     * @return object Member badges.
     * @since hk16-2
     */
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)/badges', array(
        'methods' => 'GET',
        'callback' => function($arguments) {
            wp_send_json(YipnyapGetMemberBadges($arguments['id']));
        },
    ));

    /**
     * GET /member/{id}/groups
     * @param int $id Member ID.
     * @return object Member groups.
     * @since ui3
     */
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)/groups', array(
        'methods' => 'GET',
        'callback' => function($arguments) {
            wp_send_json(YipnyapGetMemberGroups($arguments['id']));
        },
    ));

    /**
     * GET /member/{id}/friends
     * @param int $id Member ID.
     * @return object Member friends.
     * @since ui3
     */
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)/friends', array(
        'methods' => 'GET',
        'callback' => function($arguments) {
            wp_send_json(YipnyapGetMemberFriends($arguments['id']));
        },
    ));

    /**
     * GET /member/{id}
     * @param int $id Member ID.
     * @param int $bitwise Bitwise (optional).
     * @return object Member data.
     * @since hk15
     */
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)/(?P<bitwise>\d+)', array(
        'methods' => 'GET',
        'callback' => function($arguments) {
            wp_send_json(YipnyapGetMember($arguments['id'], $arguments['bitwise']));
        },
    ));
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)', array(
        'methods' => 'GET',
        'callback' => function($arguments) {
            wp_send_json(YipnyapGetMember($arguments['id']));
        },
    ));
});

/**
 * /id/
 */
add_action('rest_api_init', function () {
    /**
     * POST /id/login
     * @since hk15
     */
    register_rest_route('v2', '/id/login', array(
        'methods' => 'POST',
        'args' => [
            'username' => [
                'required' => true,
                'type' => 'string',
            ],
            'password' => [
                'required' => true,
                'type' => 'string',
            ],
        ],
        'callback' => function($request) {
            wp_send_json(YipnyapLoginMember($request['username'], $request['password']));
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
