<?php
/**
 * Functions - Stream
 * 
 * @package Yipnyap
 * 
 * @since 2022.05.2
 * 
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

if (!function_exists('yipnyap_stream_twitch_embed_src_get')) {
  /**
   * Returns iframe src for stream embed.
   * 
   * @param string  $username       Streamer username.
   * @return string $iframe_src     Iframe src for embed.
   */
  function yipnyap_stream_twitch_embed_src_get($username) {
    $stream_parent = yipnyap_settings_stream_twitch_embed_parent_get();

    $iframe_src = '//player.twitch.tv/?channel=' . $username . '&parent=' . $stream_parent;

    /**
     * Filter stream iframe src.
     * 
     * @since 2022.05.2
     * 
     * @param string $iframe_src
     * @param string $username
     * @param string $stream_parent
     */
    $iframe_src = apply_filters('yipnyap_streams_twitch_embed_iframe_src', $iframe_src, $username, $stream_parent);
  
    return $iframe_src;
  }
}
