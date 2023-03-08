<?php
/**
 * Get notifications for a user
 */
function YipnyapGetNotifications($user_id, $limit = 10, $offset = 0): array
{
    $bp_notifications = bp_notifications_get_all_notifications_for_user($user_id);
    $bp_notifications = array_slice($bp_notifications, $offset, $limit);

    $notifications = [];
    foreach ($bp_notifications as $bp_notification) {
        $build = [
            'id' => $bp_notification->id,
            'date' => strtotime($bp_notification->date_notified),
            'unread' => $bp_notification->is_new,
            'type' => $bp_notification->component_name,
            'action' => $bp_notification->component_action,
            'data' => []
        ];

        /**
         * Some reason, notification item IDs differ between components. It's either the user in question, the current
         * user, or something else.
         *
         * 'groups' => secondary_item_id
         * 'friends', 'follow' => item_id
         */
        switch ($bp_notification->component_name) {
            case 'groups':
                $build['data']['user'] = YipnyapGetMember($bp_notification->secondary_item_id);
                break;
            case 'friends':
            case 'follow':
                $build['data']['user'] = YipnyapGetMember($bp_notification->item_id);
                break;

            default:
                break;
        }

        $notifications[] = $build;
    }
    return $notifications;
}
