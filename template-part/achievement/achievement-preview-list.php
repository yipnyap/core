<?php
/**
 * Yipnyap Template Part - Achievement Preview List
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 * @see vikinger_gamipress_get_achievements
 * 
 * @param array $args {
 *   @type array  $achievements     Achievements data.
 * }
 */

?>

<!-- ACHIEVEMENT PREVIEW LIST -->
<div class="achievement-preview-list">
<?php

  foreach ($args['achievements'] as $achievement) {
    /**
     * Achievement Preview
     */
    get_template_part('template-part/achievement/achievement-preview', null, [
      'achievement' => $achievement
    ]);
  }
  
?>
</div>
<!-- /ACHIEVEMENT PREVIEW LIST -->