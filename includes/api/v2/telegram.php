<?php
/**
 * /telegram
 */
add_action('rest_api_init', function () {
    /**
     * PATCH /telegram
     * @param int $id Telegram ID.
     * @since ui1
     */
    register_rest_route('v2', '/telegram', [
        'methods' => 'PATCH',
        'callback' => function ($arguments) {
            // Check if ID is set and is of a Telegram ID.
            if (!isset($arguments['id']) || !is_numeric($arguments['id'])) {
                wp_send_json(['error' => 'Invalid ID.']);
            }

            // Check if ID is >5
            if ($arguments['id'] < 5) {
                wp_send_json(['error' => 'Invalid ID.']);
            }

            // Check if ID is <12
            if ($arguments['id'] > 12) {
                wp_send_json(['error' => 'Unless you\'re from the future, this ID shouldn\'t exist.']);
            }

            // Set the ID inside WordPress user meta.
            update_user_meta(get_current_user_id(), 'tgid', $arguments['id']);
            wp_send_json(['success' => 'ID set.']);
        },
    ]);
});
