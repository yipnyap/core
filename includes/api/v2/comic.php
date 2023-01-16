<?php
add_action('rest_api_init', function() {
    /**
     * GET /comic/arcana
     * @return object Comic metadata.
     * @since hk15
     */
    register_rest_route('v2', '/comic/arcana', [
        'methods' => 'GET',
        'callback' =>
            function() {
                $path = YIPNYAP_UPLOADS_PATH . '/member/286';
                $files = array_values(array_diff(scandir($path), array('..', '.')));

                // Loop through files, only keep ones starting with "arcana"
                $arcana = [];
                foreach ($files as $file) {
                    if (str_starts_with($file, 'arcana')) {
                        $comicEntry = str_replace('arcana-', '', $file);
                        $arcanaSplit = explode('-', $comicEntry);
                        if (isset($arcanaSplit[1])) {
                            $arcana[] = [
                                'chapter' => $arcanaSplit[0],
                                'page' => explode('.', $arcanaSplit[1])[0],
                                'image' => YIPNYAP_UPLOADS_URL . '/member/286/' . $file
                            ];
                        }
                    }
                }
                return $arcana;
            }
    ]);
});