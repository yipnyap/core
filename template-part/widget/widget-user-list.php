<?php
/**
 * Yipnyap Template Part - Widget User List
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 * @see vikinger_members_get
 * 
 * @param array $args {
 *   @type string $widget_title     Widget title.
 *   @type string $widget_subtext   Widget Subtext.
 *   @type array  $users            Users data.
 *   @type string $no_results_text  Text to show when no results are found ($users count === 0).
 *   @type array $button {
 *     @type string $text       Button text.
 *     @type string $link       Button link url.
 *   }
 * }
 */

?>

<!-- WIDGET BOX -->
<div class="widget-box">
  <!-- WIDGET BOX TITLE -->
  <p class="widget-box-title"><?php echo esc_html($args['widget_title']); ?></p>
  <?php if (array_key_exists('widget_subtext', $args)) : ?>
  <p class="text-sm opacity-90"><?php echo esc_html($args['widget_subtext']); ?></p>
  <?php endif; ?>
  <!-- /WIDGET BOX TITLE -->

  <!-- WIDGET BOX CONTENT -->
  <div class="widget-box-content">
  <?php

    if (count($args['users']) > 0) :
      /**
       * User Status List
       */
      get_template_part('template-part/user/user-status', 'list', [
        'users' => $args['users']
      ]);

      if (array_key_exists('button', $args)) :

  ?>
    <a class="widget-box-button button small primary" href="<?php echo esc_url($args['button']['link']); ?>"><?php echo esc_html($args['button']['text']); ?></a>
  <?php

      endif;

    else:

  ?>
    <p class="no-results-text"><?php echo esc_html($args['no_results_text']); ?></p>
  <?php

    endif;
    
  ?>
  </div>
  <!-- /WIDGET BOX CONTENT -->
</div>
<!-- /WIDGET BOX -->