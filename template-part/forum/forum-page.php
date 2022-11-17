<?php
/**
 * Yipnyap Template Part - Forum Page
 *
 * @package Yipnyap
 * @since 1.3.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

?>

<!-- CONTENT GRID -->
<div class="content-grid">
    <!-- FORUM HEADING -->
    <div class="forum-heading">
        <!-- FORUM PRETITLE -->
        <h2 class="forum-pretitle"><?php esc_html_e('Welcome To', 'yipnyap'); ?></h2>
        <!-- /FORUM PRETITLE -->

        <!-- FORUM TITLE -->
        <h2 class="forum-title"><?php the_title(); ?></h2>
        <!-- /FORUM TITLE -->
    </div>
    <!-- /FORUM HEADING -->
    <?php

    the_content();

    ?>
</div>
<!-- /CONTENT GRID -->
