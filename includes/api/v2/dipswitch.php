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
                $result = YipnyapCheckDipswitch($arguments['key'], $arguments['value']);
                if ($result['success']) {
                    wp_send_json([
                        'success' => true,
                        'message' => $result['message'],
                    ]);
                } else {
                    wp_send_json([
                        'success' => false,
                        'message' => $result['message'],
                    ], 400);
                }
            }
        },
    ]);
});

// @todo move this with Pivot
function YipnyapCheckDipswitch($key, mixed $value = null): array
{
    $currentDipswitch = get_user_meta(get_current_user_id(), 'dipswitch', true);
    if ($currentDipswitch === '') {
        $currentDipswitch = [];
    } else {
        $currentDipswitch = json_decode($currentDipswitch, true);
    }

    // if $value is false, we're just checking the dipswitch value
    if (empty($value) && $value !== 0) {
        if (isset($currentDipswitch[$key])) {
            return [
                'success' => true,
                'message' => 'Dipswitch value found.',
                'value' => $currentDipswitch[$key],
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Dipswitch value not found.',
            ];
        }
    }

    $allowedKeys = [
        'hide_onboarding' => 'boolean',
        'accent' => 'string',
        'PendingVerifiedDeprecationAck' => 'boolean',
        'NewUserOnboardingStep' => 'integer',
    ];

    if (!empty($allowedKeys[$key]) && (gettype($value) === $allowedKeys[$key] || $value === 0)) {
        if ($value === false) {
            // Just delete the dipswitch
            unset($currentDipswitch[$key]);
        } else {
            // Update the dipswitch
            $currentDipswitch[$key] = $value;
        }

        update_user_meta(get_current_user_id(), 'dipswitch', json_encode($currentDipswitch));

        return [
            'success' => true,
            'message' => 'Dipswitch updated.',
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Invalid dipswitch key.',
        ];
    }
}
