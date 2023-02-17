import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionIconButton from '../ActionIconButton';

function PromoteGroupMemberToAdminIconButton(props) {
    const groupable = groupUtils(props.loggedUser, props.group, props.member);

    return (
        <ActionIconButton icon="admin-crown"
                          type="accept"
                          title={yipnyap_translation.promote_to_admin}
                          action={groupable.promoteGroupMemberToAdmin}
                          onActionComplete={props.onActionComplete}
        />
    );
}

export {PromoteGroupMemberToAdminIconButton as default};
