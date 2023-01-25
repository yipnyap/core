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
            // Set the ID inside WordPress user meta.
            update_user_meta(get_current_user_id(), 'tgid', $request['id']);
            wp_send_json(['success' => true, 'message' => 'ID set.']);
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
            wp_send_json(['success' => true, 'message' => 'ID deleted.']);
        },
    ]);
});
