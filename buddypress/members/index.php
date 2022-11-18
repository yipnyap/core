<?php
/**
 * Yipnyap Template - BuddyPress Members Index
 *
 * Displays all the members of the site
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */
get_template_part('template-part/common/header/header', '', [
    'title' => 'users',
    'icon' => 'hatching-chick',
    'breadcrumbs' => [
        [
            'title' => 'Users',
            'url' => bp_get_members_directory_permalink(),
        ],
    ],
]);
?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <?php
            if (bp_has_groups()) {
                bp_get_template_part('members/members-loop');
            } else {
                get_template_part('template-part/common/no-data-found', '', [
                    'type' => 'users',
                ]);
            }
            ?>
        </div>
    </div>
</main>
