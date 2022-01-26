<?php
/**
 * Yipnyap Template Part - Navigation Section
 *
 * @param array $args {
 * @type string $section_name Section name.
 * @type array $section_links Section links.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_menu_get_items
 *
 * @package Yipnyap
 */

?>

<!-- NAVIGATION SECTION -->
<div class="navigation-section">
    <?php if ($args['section_name'] !== '') : ?>
        <!-- NAVIGATION SECTION TITLE -->
        <p class="navigation-section-title"><?php echo esc_html($args['section_name']); ?></p>
        <!-- /NAVIGATION SECTION TITLE -->
    <?php endif; ?>

    <!-- NAVIGATION SECTION LINKS -->
    <div class="navigation-section-links">
        <?php foreach ($args['section_links'] as $section_link) : ?>
            <!-- NAVIGATION SECTION LINK -->
            <a class="navigation-section-link"
               href="<?php echo esc_url($section_link['link']); ?>" <?php echo $section_link['target'] !== '' ? 'target="' . $section_link['target'] . '"' : ''; ?>><?php echo esc_html($section_link['name']); ?></a>
            <!-- /NAVIGATION SECTION LINK -->
        <?php endforeach; ?>
    </div>
    <!-- /NAVIGATION SECTION LINKS -->
</div>
<!-- /NAVIGATION SECTION -->
