<?php
/**
 * Yipnyap Template Part - Stream Preview
 * 
 * @package Yipnyap
 * @since 2022.05.2
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 * @param array $args {
 *   @type string  $username     Streamer username.
 * }
 */

  $stream_src = yipnyap_stream_twitch_embed_src_get($args['username']);

?>

<!-- IFRAME WRAP -->
<div class="iframe-wrap">
  <iframe src="<?php echo esc_url($stream_src); ?>" allowFullScreen></iframe>
</div>
<!-- /IFRAME WRAP -->

