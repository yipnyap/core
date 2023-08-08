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
            wp_send_json(YipnyapGetGroups([
                'user_id' => $arguments['id']
            ]));
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
            try {
                $user = YipnyapGetMember($arguments['id'], $arguments['bitwise']);
                wp_send_json([
                    'success' => true,
                    'data' => $user,
                ]);
            } catch (Exception $e) {
                if ($e->getCode() == 404) {
                    wp_send_json([
                        'success' => false,
                        'message' => 'Member not found.',
                    ]);
                } else {
                    wp_send_json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ]);
                }
            }
        },
    ]);
    register_rest_route('v2', '/member/(\@?)(?P<id>\S+)', [
        'methods' => 'GET',
        'callback' => function ($arguments) {
            wp_send_json(YipnyapGetMember($arguments['id']));
        },
    ]);
    register_rest_route('v2', '/member/(\@?)me', [
        'methods' => 'POST',
        'callback' => function ($arguments) {
            // Check if user is logged in
            $user = wp_get_current_user();
            if (empty($user) || $user->ID == 0) {
                wp_send_json([
                    'success' => false,
                    'message' => 'You must be logged in to do that.',
                ]);
            } else {
//                $arguments = (array) $arguments;
                $arguments = $arguments->get_params();
                wp_send_json(YipnyapUpdateMember('me', $arguments));
            }
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
            // Check if it's taken by anyone's user meta as 'athandle'
            $userExists = username_exists($request['username']) || count(get_users([
                    'meta_key' => 'athandle',
                    'meta_value' => $request['username'],
                    'fields' => 'ID',
                ])) > 0;

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
                 * ^(?=.{4,12}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$
                 *  └─────┬────┘└───┬──┘└─────┬─────┘└─────┬─────┘ └───┬───┘
                 *        │         │         │            │           no _ or . at the end
                 *        │         │         │            │
                 *        │         │         │            allowed characters
                 *        │         │         │
                 *        │         │         no __ or _. or ._ or .. inside
                 *        │         │
                 *        │         no _ or . at the beginning
                 *        │
                 *        username is 4-12 characters long
                 */
                $usernameRegexCheck = preg_match('/^(?=.{4,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/', $request['username']);
                if (!$usernameRegexCheck) {
                    wp_send_json([
                        'success' => false,
                        'message' => 'Username cannot be used.',
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
