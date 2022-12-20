<?php
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

require_once __DIR__ . '/comic.php';
require_once __DIR__ . '/member.php';
require_once __DIR__ . '/relationships.php';