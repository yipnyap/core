/**
 * General
 */
const addFollow = (config) => {
    const data = {
        action: 'yipnyap_follow_add_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const removeFollow = (config) => {
    const data = {
        action: 'yipnyap_follow_remove_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

export {
    addFollow,
    removeFollow,
};
