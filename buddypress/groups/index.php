<?php
/**
 * Yipnyap Template - BuddyPress Groups Index
 *
 * Displays all the groups of the site
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

get_template_part('template-part/common/header/header', '', [
    'title' => 'Groups',
    'icon' => 'seedling',
    'breadcrumbs' => [
        [
            'title' => 'Groups',
            'url' => bp_get_groups_directory_permalink(),
        ],
    ],
]);
?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <?php
            if (bp_has_groups()) {
                bp_get_template_part('groups/groups-loop');
            } else {
                get_template_part('template-part/common/no-data-found', '', [
                    'type' => 'groups',
                ]);
            }
            ?>
        </div>
    </div>
</main>
