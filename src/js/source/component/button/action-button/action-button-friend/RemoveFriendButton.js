import React from 'react';

import friendUtils from '@legacy/component/utils/friend';

import ActionButton from '../ActionButton';

function RemoveFriendButton(props) {
  const friendable = friendUtils(props.loggedUser, props.userID);

  return (
    <ActionButton {...props}
                  action={friendable.removeFriend}
    />
  );
}

export { RemoveFriendButton as default };