/**
 * General
 */
const getMessages = (config) => {
    const data = {
        action: 'yipnyap_get_messages_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const getMessage = (config) => {
    const data = {
        action: 'yipnyap_get_message_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const sendMessage = (config) => {
    const data = {
        action: 'yipnyap_send_message_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const deleteMessageThread = (config) => {
    const data = {
        action: 'yipnyap_delete_message_thread_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const starMessage = (config) => {
    const data = {
        action: 'yipnyap_star_message_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const unstarMessage = (config) => {
    const data = {
        action: 'yipnyap_unstar_message_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const markMessageThreadAsRead = (config) => {
    const data = {
        action: 'yipnyap_message_mark_thread_as_read_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

export {
    getMessages,
    getMessage,
    sendMessage,
    deleteMessageThread,
    starMessage,
    unstarMessage,
    markMessageThreadAsRead
};
