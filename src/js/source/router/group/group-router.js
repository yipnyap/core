/**
 * General
 */
const getGroups = (config) => {
    const data = {
        action: 'yipnyap_groups_get_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const getGroupsCount = (config, callback) => {
    const data = {
        action: 'yipnyap_groups_get_count_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    jQuery.post(yipnyap_constants.ajax_url, data, callback);
};

const createGroup = (config) => {
    const data = {
        action: 'yipnyap_group_create_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const updateGroup = (config) => {
    const data = {
        action: 'yipnyap_group_update_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const deleteGroup = (config) => {
    const data = {
        action: 'yipnyap_group_delete_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

/**
 * Metadata
 */
const updateGroupMetaFields = (config) => {
    const data = {
        action: 'yipnyap_group_update_meta_fields_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

const deleteGroupMetaFields = (config) => {
    const data = {
        action: 'yipnyap_group_delete_meta_fields_ajax',
        args: config,
        _ajax_nonce: yipnyap_constants.yipnyap_ajax_nonce
    };

    return jQuery.post(yipnyap_constants.ajax_url, data);
};

/**
 * Avatar
 */
const uploadGroupAvatar = (config) => {
    const formData = new FormData();

    formData.set('context', 'edit');
    formData.set('action', 'bp_avatar_upload');
    formData.set('file', config.file);

    return jQuery.ajax({
        url: `${yipnyap_constants.rest_root}buddypress/v1/groups/${config.group_id}/avatar`,
        method: 'POST',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', yipnyap_constants.wp_rest_nonce);
        },
        data: formData,
        contentType: false,
        processData: false
    });
};

/**
 * Cover
 */
const uploadGroupCover = (config) => {
    const formData = new FormData();

    formData.set('context', 'edit');
    formData.set('action', 'bp_cover_image_upload');
    formData.set('file', config.file);

    return jQuery.ajax({
        url: `${yipnyap_constants.rest_root}buddypress/v1/groups/${config.group_id}/cover`,
        method: 'POST',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', yipnyap_constants.wp_rest_nonce);
        },
        data: formData,
        contentType: false,
        processData: false
    });
};

export {
    getGroups,
    getGroupsCount,
    createGroup,
    updateGroup,
    deleteGroup,
    updateGroupMetaFields,
    deleteGroupMetaFields,
    uploadGroupAvatar,
    uploadGroupCover
};
