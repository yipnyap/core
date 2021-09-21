import React from 'react';

import followUtils from '../../../utils/follow';

import ActionButton from '../ActionButton';

function UnollowButton(props) {
  const followable = followUtils(props.loggedUser, props.userID);

  return (
    <ActionButton {...props}
                  action={followable.removeFollow}
    />
  );
}

export { UnollowButton as default };