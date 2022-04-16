<?php
/**
 * Yipnyap Template - BuddyPress Groups Index
 * 
 * Displays all the groups of the site
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

?>

<!-- CONTENT GRID -->
<div class="content-grid">
<?php

  $page_header_status = get_theme_mod('yipnyap_pageheader_setting_display', 'hide');

  if ($page_header_status === 'display') {
    $group_header_icon_id      = get_theme_mod('yipnyap_pageheader_group_setting_image', false);
    $group_header_title        = get_theme_mod('yipnyap_pageheader_group_setting_title', esc_html_x('Groups', 'Groups Page - Title', 'yipnyap'));
    $group_header_description  = get_theme_mod('yipnyap_pageheader_group_setting_description', esc_html_x('Browse all the groups of the community!', 'Groups Page - Description', 'yipnyap'));

    if ($group_header_icon_id) {
      $group_header_icon_url = wp_get_attachment_image_src($group_header_icon_id , 'full')[0];
    } else {
      $group_header_icon_url = yipnyap_customizer_group_page_image_get_default();
    }

    /**
     * Section Banner
     */
    get_template_part('template-part/section/section', 'banner', [
      'section_icon_url'    => $group_header_icon_url,
      'section_title'       => $group_header_title,
      'section_description' => $group_header_description
    ]);
  }

  bp_get_template_part('groups/groups-loop');

?>
</div>
<!-- /CONTENT GRID -->
