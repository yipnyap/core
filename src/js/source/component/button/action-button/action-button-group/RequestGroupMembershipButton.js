import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionButton from '../ActionButton';

function RequestGroupMembershipButton(props) {
  const groupable = groupUtils(props.loggedUser, props.group);

  return (
    <ActionButton {...props}
                  action={groupable.requestGroupMembership}
    />
  );
}

export { RequestGroupMembershipButton as default };
