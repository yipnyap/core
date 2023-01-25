/**
 * General
 */
const addFriend = (config) => {
    const data = {
        action: 'yipnyap_friend_add_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const removeFriend = (config) => {
    const data = {
        action: 'yipnyap_friend_remove_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const withdrawFriendRequest = (config) => {
    const data = {
        action: 'yipnyap_friend_withdraw_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const acceptFriendRequest = (config) => {
    const data = {
        action: 'yipnyap_friend_accept_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const rejectFriendRequest = (config) => {
    const data = {
        action: 'yipnyap_friend_reject_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

export {
    addFriend,
    removeFriend,
    withdrawFriendRequest,
    acceptFriendRequest,
    rejectFriendRequest
};
