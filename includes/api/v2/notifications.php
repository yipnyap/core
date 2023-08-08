<?php
/**
 * /notifications/
 */
add_action('rest_api_init', function () {
    /**
     * GET /notifications
     * @param int $limit Limit (optional).
     * @param int $offset Offset (optional).
     * @return object Notifications.
     * @since hk16-2
     */
    register_rest_route('v2', '/notifications', [
        'methods' => 'GET',
        'callback' => function ($arguments) {
            if (!is_user_logged_in()) {
                wp_send_json_error('Not logged in');
            }
            $limit = $arguments['limit'] ?? 10;
            $offset = $arguments['offset'] ?? 0;
            wp_send_json(YipnyapGetNotifications(get_current_user_id(), $limit, $offset));
        },
    ]);
});