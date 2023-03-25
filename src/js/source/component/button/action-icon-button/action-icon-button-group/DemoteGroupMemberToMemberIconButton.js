import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionIconButton from '../ActionIconButton';

function DemoteGroupMemberToMemberIconButton(props) {
    const groupable = groupUtils(props.loggedUser, props.group, props.member);

    return (
        <ActionIconButton icon="members"
                          type="decline"
                          title={yipnyap_translation.demote_to_member}
                          action={groupable.demoteGroupMemberToMember}
                          onActionComplete={props.onActionComplete}
        />
    );
}

export {DemoteGroupMemberToMemberIconButton as default};
