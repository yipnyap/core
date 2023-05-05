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
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)/badges', [
        'methods' => 'GET',
        'callback' => function ($arguments) {
            wp_send_json(YipnyapGetMemberBadges($arguments['id']));
        },
    ]);

    /**
     * GET /member/{id}/groups
     * @param int $id Member ID.
     * @return object Member groups.
     * @since ui1
     */
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)/groups', [
        'methods' => 'GET',
        'callback' => function ($arguments) {
            wp_send_json(YipnyapGetMemberGroups($arguments['id']));
        },
    ]);

    /**
     * GET /member/{id}/friends
     * @param int $id Member ID.
     * @return object Member friends.
     * @since ui1
     */
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)/friends', [
        'methods' => 'GET',
        'callback' => function ($arguments) {
            wp_send_json(YipnyapGetMemberFriends($arguments['id']));
        },
    ]);

    /**
     * GET /member/{id}
     * @param int $id Member ID.
     * @param int $bitwise Bitwise (optional).
     * @return object Member data.
     * @since hk15
     */
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)/(?P<bitwise>\d+)', [
        'methods' => 'GET',
        'callback' => function ($arguments) {
            wp_send_json(YipnyapGetMember($arguments['id'], $arguments['bitwise']));
        },
    ]);
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)', [
        'methods' => 'GET',
        'callback' => function ($arguments) {
            wp_send_json(YipnyapGetMember($arguments['id']));
        },
    ]);
});

/**
 * /id/
 */
add_action('rest_api_init', function () {
    /**
     * POST /id/login
     * @since hk15
     */
    register_rest_route('v2', '/id/login', [
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
            'remember' => [
                'required' => false,
                'type' => 'boolean',
            ],
            'otp' => [
                'required' => false,
                'type' => 'string',
            ],
        ],
        'callback' => function ($request) {
            wp_send_json(YipnyapLoginMember($request['username'], $request['password'], $request['otp'], $request['remember']));
        },
    ]);

    /**
     * POST /id/register
     * @since ui1
     */
    register_rest_route('v2', '/id/register', [
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
        'callback' => function ($request) {
            // Register member to WordPress.
            $userExists = username_exists($request['username']);
            if ($userExists) {
                wp_send_json([
                    'success' => false,
                    'message' => 'Username already exists.',
                ]);
            } else {
                /*
                 * Read reserved.json, check if username contains it
                 */
                $reservedUsernames = json_decode(file_get_contents('reserved.json', true), true);
                foreach ($reservedUsernames as $reservedUsername) {
                    if (stripos($request['username'], $reservedUsername) === 0) {
                        wp_send_json([
                            'success' => false,
                            'message' => 'Username is invalid - contains a restricted phrase at a restricted point.',
                        ]);
                    }
                }

                /*
                 * ^(?=.{4,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$
                 *  └─────┬────┘└───┬──┘└─────┬─────┘└─────┬─────┘ └───┬───┘
                 *        │         │         │            │           no _ or . at the end
                 *        │         │         │            │
                 *        │         │         │            allowed characters
                 *        │         │         │
                 *        │         │         no __ or _. or ._ or .. inside
                 *        │         │
                 *        │         no _ or . at the beginning
                 *        │
                 *        username is 4-20 characters long ( ͡° ͜ʖ ͡°)
                 */
                $usernameRegexCheck = preg_match('/^(?=.{4,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/', $request['username']);
                if (!$usernameRegexCheck) {
                    wp_send_json([
                        'success' => false,
                        'message' => 'Username is invalid - doesn\'t follow naming structure.',
                    ]);
                } else {
                    $user = wp_create_user($request['username'], $request['password']);
                    if (is_wp_error($user)) {
                        wp_send_json([
                            'success' => false,
                            'message' => $user->get_error_message(),
                        ]);
                    } else {
                        // Create a unique E2 ID
                        $E2ID = E2IDCreate('User');
                        update_user_meta($user, 'E2ID', $E2ID);
                        wp_send_json(YipnyapLoginMember($request['username'], $request['password']));
                    }
                }
            }
        },
    ]);

    /**
     * POST /id/recover
     * @since ui1
     */
    register_rest_route('v2', '/id/recover', [
        'methods' => 'POST',
        'args' => [
            'username' => [
                'required' => true,
                'type' => 'string',
            ],
            'password' => [
                'required' => false,
                'type' => 'string',
            ],
            'otp' => [
                'required' => false,
                'type' => 'string',
            ],
        ],
        'callback' => function ($request) {
            // Check if user exists
            $userExists = username_exists($request['username']);
            if (!$userExists) {
                wp_send_json([
                    'success' => false,
                    'message' => 'Username doesn\'t exist.',
                ]);
            } else {
                $YipnyapUser = YipnyapGetMember($userExists, null, true);
                if (empty($YipnyapUser['tgid'])) {
                    wp_send_json([
                        'success' => false,
                        'message' => 'Cannot recover an unclaimed account. If you completely lost access, you\'re out of luck. Create a new account.',
                    ]);
                }
                $OTPResult = YipnyapCheckOTP($YipnyapUser, $request['otp']);
                if (!$OTPResult['success']) {
                    // If OTP is missing or incorrect
                    wp_send_json($OTPResult);
                } elseif (empty($request['password'])) {
                    wp_send_json([
                        'success' => false,
                        'message' => 'Password is required.',
                    ]);
                } else {
                    // User is verified, reset password
                    wp_set_password($request['password'], $userExists);
                    wp_send_json([
                        'success' => true,
                        'message' => 'Password reset successfully.',
                    ]);
                }
            }
        }
    ]);
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
    register_rest_route('v2', '/bitwise', [
        'methods' => 'GET',
        'callback' => function () {
            wp_send_json(YipnyapGetBitwiseValues());
        },
    ]);
});
