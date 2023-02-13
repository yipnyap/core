<?php
/**
 * Yipnyap Template Part - Notification Section
 * 
 * @package Yipnyap
 * @since 2022.05.2
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 * @param array $args {
 *   @type string  $title     Notification title.
 *   @type string  $text      Notification text.
 * }
 */

?>

<!-- NOTIFICATION SECTION -->
<div class="notification-section">
<?php

  /**
   * Icon SVG
   */
  get_template_part('template-part/icon/icon', 'svg', [
    'icon'      => 'no-results',
    'modifiers' => 'notification-section-icon'
  ]);

?>
  <!-- NOTIFICATION SECTION TITLE -->
  <p class="notification-section-title"><?php echo esc_html($args['title']); ?></p>
  <!-- /NOTIFICATION SECTION TITLE -->

  <!-- NOTIFICATION SECTION TEXT -->
  <p class="notification-section-text"><?php echo wp_kses($args['text'], ['a' => ['href' => []]]); ?></p>
  <!-- /NOTIFICATION SECTION TEXT -->
</div>
<!-- /NOTIFICATION SECTION -->
