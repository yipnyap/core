import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionIconButton from '../ActionIconButton';

function UnbanGroupMemberIconButton(props) {
    const groupable = groupUtils(props.loggedUser, props.group, props.member);

    return (
        <ActionIconButton icon="ban"
                          type="accept"
                          title={yipnyap_translation.unban_member}
                          action={groupable.unbanGroupMember}
                          onActionComplete={props.onActionComplete}
        />
    );
}

export {UnbanGroupMemberIconButton as default};
