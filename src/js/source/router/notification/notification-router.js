/**
 * General
 */
const getNotifications = (config = {}) => {
    const data = {
        action: 'yipnyap_get_notifications_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const getUnreadNotificationsCount = (config = {}) => {
    const data = {
        action: 'yipnyap_get_unread_notifications_count_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const markNotificationAsRead = (config) => {
    const data = {
        action: 'yipnyap_mark_notification_as_read_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const markNotificationsAsRead = (config) => {
    const data = {
        action: 'yipnyap_mark_notifications_as_read_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const deleteNotifications = (config) => {
    const data = {
        action: 'yipnyap_delete_notifications_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

export {
    getNotifications,
    getUnreadNotificationsCount,
    markNotificationAsRead,
    markNotificationsAsRead,
    deleteNotifications
};
