<?php
/**
 * Get notifications for a user
 */
function YipnyapGetNotifications($user_id, $limit = 10, $offset = 0)
{
    $bp_notifications = bp_notifications_get_all_notifications_for_user($user_id);
    $bp_notifications = array_slice($bp_notifications, $offset, $limit);

    $notifications = [];
    foreach ($bp_notifications as $bp_notification) {
        $build = [
            'id' => $bp_notification->id,
            'date' => strtotime($bp_notification->date_notified),
            'unread' => $bp_notification->is_new,
            'action' => $bp_notification->component_name . '::' . $bp_notification->component_action,
            'data' => []
        ];

        switch ($bp_notification->component_name) {
            case 'friends':
            case 'follow':
                $build['data']['user'] = [
                    'id' => $bp_notification->item_id,
                    'name' => bp_core_get_user_displayname($bp_notification->item_id),
                    'avatar' => bp_core_fetch_avatar([
                        'item_id' => $bp_notification->item_id,
                        'type' => 'full',
                        'html' => false,
                    ]),
                ];
                break;

            default:
                break;
        }

        $notifications[] = $build;
    }
    return $notifications;
}
