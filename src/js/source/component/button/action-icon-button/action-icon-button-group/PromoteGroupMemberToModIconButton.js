import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionIconButton from '../ActionIconButton';

function PromoteGroupMemberToModIconButton(props) {
    const groupable = groupUtils(props.loggedUser, props.group, props.member);

    return (
        <ActionIconButton icon="mod-shield"
                          type="accept"
                          title={yipnyap_translation.promote_to_mod}
                          action={groupable.promoteGroupMemberToMod}
                          onActionComplete={props.onActionComplete}
        />
    );
}

export {PromoteGroupMemberToModIconButton as default};
