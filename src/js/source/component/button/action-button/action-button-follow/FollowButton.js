import React from 'react';

import followUtils from '../../../utils/follow';

import ActionButton from '../ActionButton';

function FollowButton(props) {
  const followable = followUtils(props.loggedUser, props.userID);

  return (
    <ActionButton {...props}
                  action={followable.addFollow}
    />
  );
}

export { FollowButton as default };