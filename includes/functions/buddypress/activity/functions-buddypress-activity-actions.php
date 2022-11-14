<?php
/**
 * Functions - BuddyPress - Activity - Actions
 *
 * @package Yipnyap
 *
 * @since 2022.05.2
 *
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

if (!function_exists('yipnyap_register_activity_media_upload_action')) {
    /**
     * Register activity_media_upload custom action
     */
    function yipnyap_register_activity_media_upload_action()
    {
        bp_activity_set_action(
            'activity',
            'activity_media_upload',
            esc_html_x('Posted a photo upload', '(Backend) Activity Media Upload Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_media_upload',
            esc_html_x('Media upload post', '(Backend) Activity Media Upload Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_media_upload_action');

if (!function_exists('yipnyap_register_activity_media_upload_group_action')) {
    /**
     * Register activity_media_upload custom group action
     */
    function yipnyap_register_activity_media_upload_group_action()
    {
        bp_activity_set_action(
            'groups',
            'activity_media_upload',
            esc_html_x('Posted a photo upload', '(Backend) Activity Media Upload Group Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_media_upload_group',
            esc_html_x('Media upload post', '(Backend) Activity Media Upload Group Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_media_upload_group_action');

if (!function_exists('yipnyap_format_action_activity_media_upload')) {
    /**
     * Action string format for the activity_media_upload action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_media_upload($action, $activity)
    {
        $action = esc_html_x('uploaded photos', 'Activity Media Upload Action - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_format_action_activity_media_upload_group')) {
    /**
     * Action string format for the activity_media_upload action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_media_upload_group($action, $activity)
    {
        $action = esc_html_x('uploaded photos in the group', 'Activity Media Upload Action Group - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_register_activity_media_update_action')) {
    /**
     * Register activity_media_update custom action
     */
    function yipnyap_register_activity_media_update_action()
    {
        bp_activity_set_action(
            'activity',
            'activity_media_update',
            esc_html_x('Posted a photo update', '(Backend) Activity Media Update Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_media_update',
            esc_html_x('Media update', '(Backend) Activity Media Update Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_media_update_action');

if (!function_exists('yipnyap_register_activity_media_update_group_action')) {
    /**
     * Register activity_media_update custom group action
     */
    function yipnyap_register_activity_media_update_group_action()
    {
        bp_activity_set_action(
            'groups',
            'activity_media_update',
            esc_html_x('Posted a photo update', '(Backend) Activity Media Update Group Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_media_update_group',
            esc_html_x('Media update', '(Backend) Activity Media Update Group Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_media_update_group_action');

if (!function_exists('yipnyap_format_action_activity_media_update')) {
    /**
     * Action string format for the activity_media_update action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_media_update($action, $activity)
    {
        $action = ''; //esc_html_x('posted a photo update', 'Activity Media Update Action - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_format_action_activity_media_update_group')) {
    /**
     * Action string format for the activity_media_update action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_media_update_group($action, $activity)
    {
        $action = esc_html_x('in', 'Activity Media Update Action Group - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_register_activity_media_action')) {
    /**
     * Register activity_media custom action
     */
    function yipnyap_register_activity_media_action()
    {
        bp_activity_set_action(
            'activity',
            'activity_media',
            esc_html_x('Uploaded a photo', '(Backend) Activity Media Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_media',
            esc_html_x('Media upload', '(Backend) Activity Media Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_media_action');

if (!function_exists('yipnyap_register_activity_media_group_action')) {
    /**
     * Register activity_media custom group action
     */
    function yipnyap_register_activity_media_group_action()
    {
        bp_activity_set_action(
            'groups',
            'activity_media',
            esc_html_x('Uploaded a photo', '(Backend) Activity Media Group Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_media_group',
            esc_html_x('Media upload', '(Backend) Activity Media Group Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_media_group_action');

if (!function_exists('yipnyap_format_action_activity_media')) {
    /**
     * Action string format for the activity_media action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_media($action, $activity)
    {
        $action = esc_html_x('uploaded a photo', 'Activity Media Action - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_format_action_activity_media_group')) {
    /**
     * Action string format for the activity_media action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_media_group($action, $activity)
    {
        $action = esc_html_x('in', 'Activity Media Action Group - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_register_activity_video_upload_action')) {
    /**
     * Register activity_video_upload custom action
     */
    function yipnyap_register_activity_video_upload_action()
    {
        bp_activity_set_action(
            'activity',
            'activity_video_upload',
            esc_html_x('Posted a video upload', '(Backend) Activity Video Upload Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_video_upload',
            esc_html_x('Video upload post', '(Backend) Activity Video Upload Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_video_upload_action');

if (!function_exists('yipnyap_register_activity_video_upload_group_action')) {
    /**
     * Register activity_video_upload custom group action
     */
    function yipnyap_register_activity_video_upload_group_action()
    {
        bp_activity_set_action(
            'groups',
            'activity_video_upload',
            esc_html_x('Posted a video upload', '(Backend) Activity Video Upload Group Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_video_upload_group',
            esc_html_x('Video upload post', '(Backend) Activity Video Upload Group Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_video_upload_group_action');

if (!function_exists('yipnyap_format_action_activity_video_upload')) {
    /**
     * Action string format for the activity_video_upload action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_video_upload($action, $activity)
    {
        $action = esc_html_x('uploaded a video', 'Activity Video Upload Action - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_format_action_activity_video_upload_group')) {
    /**
     * Action string format for the activity_video_upload action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_video_upload_group($action, $activity)
    {
        $action = esc_html_x('uploaded a video in the group', 'Activity Video Upload Action Group - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_register_activity_video_update_action')) {
    /**
     * Register activity_video_update custom action
     */
    function yipnyap_register_activity_video_update_action()
    {
        bp_activity_set_action(
            'activity',
            'activity_video_update',
            '',
            'yipnyap_format_action_activity_video_update',
            esc_html_x('Video update', '(Backend) Activity Video Update Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_video_update_action');

if (!function_exists('yipnyap_register_activity_video_update_group_action')) {
    /**
     * Register activity_video_update custom group action
     */
    function yipnyap_register_activity_video_update_group_action()
    {
        bp_activity_set_action(
            'groups',
            'activity_video_update',
            '',
            'yipnyap_format_action_activity_video_update_group',
            esc_html_x('Video update', '(Backend) Activity Video Update Group Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_video_update_group_action');

if (!function_exists('yipnyap_format_action_activity_video_update')) {
    /**
     * Action string format for the activity_video_update action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_video_update($action, $activity)
    {
        $action = esc_html_x('posted a video update', 'Activity Video Update Action - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_format_action_activity_video_update_group')) {
    /**
     * Action string format for the activity_video_update action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_video_update_group($action, $activity)
    {
        $action = esc_html_x('in', 'Activity Video Update Action Group - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_register_activity_video_action')) {
    /**
     * Register activity_video custom action
     */
    function yipnyap_register_activity_video_action()
    {
        bp_activity_set_action(
            'activity',
            'activity_video',
            esc_html_x('Uploaded a video', '(Backend) Activity Video Action - Description', 'yipnyap'),
            '',
            esc_html_x('Video upload', '(Backend) Activity Video Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_video_action');

if (!function_exists('yipnyap_register_activity_video_group_action')) {
    /**
     * Register activity_video custom group action
     */
    function yipnyap_register_activity_video_group_action()
    {
        bp_activity_set_action(
            'groups',
            'activity_video',
            esc_html_x('Uploaded a video', '(Backend) Activity Video Group Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_video_group',
            esc_html_x('Video upload', '(Backend) Activity Video Group Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_video_group_action');

if (!function_exists('yipnyap_format_action_activity_video_group')) {
    /**
     * Action string format for the activity_video action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_video_group($action, $activity)
    {
        $action = esc_html_x('in', 'Activity Video Action Group - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_register_activity_share_action')) {
    /**
     * Register activity_share custom action
     */
    function yipnyap_register_activity_share_action()
    {
        bp_activity_set_action(
            'activity',
            'activity_share',
            esc_html_x('Rehowled', '(Backend) Post Rehowl Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_share',
            esc_html_x('Post Rehowl', '(Backend) Post Rehowl Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_share_action');

if (!function_exists('yipnyap_register_activity_share_group_action')) {
    /**
     * Register activity_share custom group action
     */
    function yipnyap_register_activity_share_group_action()
    {
        bp_activity_set_action(
            'groups',
            'activity_share',
            esc_html_x('Rehowled', '(Backend) Post Rehowl Group Action - Description', 'yipnyap'),
            'yipnyap_format_action_activity_share_group',
            esc_html_x('Post Rehowl', '(Backend) Post Rehowl Group Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_activity_share_group_action');

if (!function_exists('yipnyap_format_action_activity_share')) {
    /**
     * Action string format for the activity_share action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_share($action, $activity)
    {
        $action = esc_html_x('rehowled', 'Post Rehowl - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_format_action_activity_share_group')) {
    /**
     * Action string format for the activity_share group action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_activity_share_group($action, $activity)
    {
        $action = esc_html_x('rehowled in', 'Post Rehowl Group - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_register_post_share_action')) {
    /**
     * Register post_share custom action
     */
    function yipnyap_register_post_share_action()
    {
        bp_activity_set_action(
            'activity',
            'post_share',
            esc_html_x('Shared a blog post', '(Backend) Post Share Action - Description', 'yipnyap'),
            'yipnyap_format_action_post_share',
            esc_html_x('Post Share', '(Backend) Post Share Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_post_share_action');

if (!function_exists('yipnyap_register_post_share_group_action')) {
    /**
     * Register post_share custom group action
     */
    function yipnyap_register_post_share_group_action()
    {
        bp_activity_set_action(
            'groups',
            'post_share',
            esc_html_x('Shared a blog post', '(Backend) Post Share Group Action - Description', 'yipnyap'),
            'yipnyap_format_action_post_share_group',
            esc_html_x('Post Share', '(Backend) Post Share Group Action - Label', 'yipnyap')
        );
    }
}

add_action('bp_register_activity_actions', 'yipnyap_register_post_share_group_action');

if (!function_exists('yipnyap_format_action_post_share')) {
    /**
     * Action string format for the post_share action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_post_share($action, $activity)
    {
        $action = esc_html_x('reposted', 'Post Share Action - Text', 'yipnyap');

        return $action;
    }
}

if (!function_exists('yipnyap_format_action_post_share_group')) {
    /**
     * Action string format for the post_share action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_format_action_post_share_group($action, $activity)
    {
        $action = esc_html_x('reposted in', 'Post Share Action Group - Text', 'yipnyap');

        return $action;
    }
}

?>
