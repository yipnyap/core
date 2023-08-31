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
        'args' => [
            'id' => [
                'required' => true,
                'type' => 'integer',
            ],
        ],
        'callback' => function ($request) {
            if (!is_user_logged_in()) wp_send_json(['success' => false, 'message' => 'You must be logged in to do that.'], 401);
            // Set the ID inside WordPress user meta.
            $success = update_user_meta(get_current_user_id(), 'tgid', $request['id']);
            if ($success !== false) {
                wp_send_json(['success' => true, 'message' => 'ID set.']);
            } else {
                wp_send_json(['success' => false, 'message' => 'ID not set.']);
            }
        },
    ]);

    /**
     * DELETE /telegram
     * @since ui1
     */
    register_rest_route('v2', '/telegram', [
        'methods' => 'DELETE',
        'callback' => function () {
            // Delete the ID inside WordPress user meta.
            delete_user_meta(get_current_user_id(), 'tgid');
            delete_user_meta(get_current_user_id(), 'SecureID:Level');
            wp_send_json(['success' => true, 'message' => 'ID deleted.']);
        },
    ]);

    /**
     * PATCH /telegram/secureid
     * @param int $level Secure ID Level.
     * @since ui1.3
     */
    register_rest_route('v2', '/telegram/secureid', [
        'methods' => 'PATCH',
        'args' => [
            'level' => [
                'required' => true,
                'type' => 'string',
            ],
        ],
        'callback' => function ($request) {
            if (!in_array($request['level'], ['default', 'medium', 'high']))
                wp_send_json(['success' => false, 'message' => 'Invalid Secure ID Level.'], 400);
            // Set the Secure ID Level inside WordPress user meta.
            update_user_meta(get_current_user_id(), 'SecureID:Level', $request['level']);
            wp_send_json(['success' => true, 'message' => 'Secure ID Level set.']);
        },
    ]);
});
