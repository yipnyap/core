<?php
/**
 * /dipswitch/
 */
add_action('rest_api_init', function () {
    /**
     * POST /dipswitch/
     *
     * @param int $key Dipswitch key.
     * @param int $value Dipswitch value.
     * @since ui1.3
     */
    register_rest_route('v2', '/dipswitch/', [
        'methods' => 'POST',
        'args' => [
            'key' => [
                'required' => true,
                'type' => 'string',
            ],
            'value' => [
                'required' => true,
            ],
        ],
        'callback' => function ($arguments) {
            if (!is_user_logged_in()) {
                wp_send_json([
                    'success' => false,
                    'message' => 'You are not logged in.',
                ], 401);
            } else {
                $key = $arguments['key'];
                $value = $arguments['value'];
                $currentDipswitch = get_user_meta(get_current_user_id(), 'dipswitch', true);
                if ($currentDipswitch === '') {
                    $currentDipswitch = [];
                } else {
                    $currentDipswitch = json_decode($currentDipswitch, true);
                }

                $allowedKeys = [
                    'hide_onboarding' => 'boolean',
                    'accent' => 'string',
                ];

                if (!empty($allowedKeys[$key]) && gettype($value) === $allowedKeys[$key]) {
                    $currentDipswitch[$key] = $value;
                    update_user_meta(get_current_user_id(), 'dipswitch', json_encode($currentDipswitch));
                    wp_send_json([
                        'success' => true,
                        'message' => 'Dipswitch updated.',
                    ]);
                } else {
                    wp_send_json([
                        'success' => false,
                        'message' => 'Invalid dipswitch key.',
                    ], 400);
                }
            }
        },
    ]);
});
