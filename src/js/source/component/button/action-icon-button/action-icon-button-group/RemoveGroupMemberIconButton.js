import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionIconButton from '../ActionIconButton';

function RemoveGroupMemberIconButton(props) {
    const groupable = groupUtils(props.loggedUser, props.group, props.member);

    return (
        <ActionIconButton icon="remove-user"
                          type="decline"
                          title={yipnyap_translation.remove_member}
                          action={groupable.removeGroupMember}
                          onActionComplete={props.onActionComplete}
        />
    );
}

export {RemoveGroupMemberIconButton as default};
