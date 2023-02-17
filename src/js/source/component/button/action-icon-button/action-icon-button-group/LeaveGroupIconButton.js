import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionIconButton from '../ActionIconButton';

function LeaveGroupIconButton(props) {
    const groupable = groupUtils(props.loggedUser, props.group);

    return (
        <ActionIconButton icon="leave-group"
                          type="decline"
                          title={yipnyap_translation.leave_group}
                          action={groupable.leaveGroup}
                          onActionComplete={props.onActionComplete}
        />
    );
}

export {LeaveGroupIconButton as default};
