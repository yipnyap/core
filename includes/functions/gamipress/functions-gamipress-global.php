<?php
/**
 * Functions - GamiPress - Global
 *
 * @package Yipnyap
 *
 * @since 2022.05.2
 *
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

if (!function_exists('yipnyap_gamipress_post_types_get')) {
    /**
     * Get GamiPress post types
     */
    function yipnyap_gamipress_post_types_get()
    {
        $achievement_types = yipnyap_gamipress_achievement_types_get_flat();
        $rank_types = yipnyap_gamipress_rank_types_get_flat();

        $post_types = [];

        $post_types = array_merge($post_types, $achievement_types);
        $post_types = array_merge($post_types, $rank_types);

        return $post_types;
    }
}

if (!function_exists('yipnyap_gamipress_achievement_types_get_flat')) {
    /**
     * Get flattened GamiPress achievement types
     */
    function yipnyap_gamipress_achievement_types_get_flat()
    {
        $gp_achievement_types = yipnyap_gamipress_get_achievement_types();

        $achievement_types = [];

        foreach ($gp_achievement_types as $key => $gp_achievement_type) {
            $achievement_types[] = $key;
        }

        return $achievement_types;
    }
}

if (!function_exists('yipnyap_gamipress_rank_types_get_flat')) {
    /**
     * Get flattened GamiPress rank types
     */
    function yipnyap_gamipress_rank_types_get_flat()
    {
        $gp_rank_types = yipnyap_gamipress_get_rank_types();

        $rank_types = [];

        foreach ($gp_rank_types as $key => $gp_rank_type) {
            $rank_types[] = $key;
        }

        return $rank_types;
    }
}

if (!function_exists('yipnyap_gamipress_type_get')) {
    /**
     * Get GamiPress type by post type
     *
     * @param string $post_type Post type.
     * @return string|bool  $gp_type      GamiPress element type or false if invalid post_type. One of: 'achievement', 'rank'.
     */
    function yipnyap_gamipress_type_get($post_type)
    {
        $achievement_types = yipnyap_gamipress_achievement_types_get_flat();
        $rank_types = yipnyap_gamipress_rank_types_get_flat();

        if (in_array($post_type, $achievement_types)) {
            return 'achievement';
        }

        if (in_array($post_type, $rank_types)) {
            return 'rank';
        }

        return false;
    }
}
