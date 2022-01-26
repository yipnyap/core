<?php
/**
 * Yipnyap Template Part - Dropdown Navigation
 *
 * @param array $args {
 * @type string $section_name Section name.
 * @type array $section_links Section links.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_members_get_settings_navigation_sections
 *
 * @package Yipnyap
 */

?>

<!-- DROPDOWN NAVIGATION CATEGORY -->
<p class="dropdown-navigation-category"><?php echo esc_html($args['section_name']); ?></p>
<!-- /DROPDOWN NAVIGATION CATEGORY -->

<?php foreach ($args['section_links'] as $section_link) : ?>
    <!-- DROPDOWN NAVIGATION LINK -->
    <a class="dropdown-navigation-link"
       href="<?php echo esc_url($section_link['link']); ?>"><?php echo esc_html($section_link['name']); ?></a>
    <!-- /DROPDOWN NAVIGATION LINK -->
<?php endforeach; ?>
