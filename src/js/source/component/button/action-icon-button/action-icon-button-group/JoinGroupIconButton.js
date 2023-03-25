import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionIconButton from '../ActionIconButton';

function JoinGroupIconButton(props) {
    const groupable = groupUtils(props.loggedUser, props.group);

    return (
        <ActionIconButton icon="join-group"
                          type="accept"
                          title={yipnyap_translation.join_group}
                          action={groupable.joinGroup}
                          onActionComplete={props.onActionComplete}
        />
    );
}

export {JoinGroupIconButton as default};
