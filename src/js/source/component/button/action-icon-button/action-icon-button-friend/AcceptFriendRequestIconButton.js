import React from 'react';

import friendUtils from '@legacy/component/utils/friend';

import ActionIconButton from '../ActionIconButton';

function AcceptFriendRequestIconButton(props) {
    const friendable = friendUtils(props.loggedUser, props.userID);

    return (
        <ActionIconButton icon="add-friend"
                          type="accept"
                          title={yipnyap_translation.accept_friend}
                          action={friendable.acceptFriendRequest}
                          onActionStart={props.onActionStart}
                          onActionComplete={props.onActionComplete}
                          locked={props.locked}
        />
    );
}

export {AcceptFriendRequestIconButton as default};
