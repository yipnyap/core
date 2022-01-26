/**
 * General
 */
const getLoggedInMember = (config) => {
    const data = {
        action: 'yipnyap_get_logged_user_member_data_ajax',
        data_scope: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

/**
 * Metadata
 */
const updateLoggedUserGridType = (config) => {
    const data = {
        action: 'yipnyap_logged_user_grid_type_update_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const updateLoggedUserSidemenuStatus = (config) => {
    const data = {
        action: 'yipnyap_logged_user_sidemenu_status_update_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const toggleLoggedUserColorTheme = () => {
    const data = {
        action: 'yipnyap_logged_user_color_theme_toggle_ajax',
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

export {
    getLoggedInMember,
    updateLoggedUserGridType,
    updateLoggedUserSidemenuStatus,
    toggleLoggedUserColorTheme
};
