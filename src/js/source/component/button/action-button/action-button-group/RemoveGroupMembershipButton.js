import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionButton from '../ActionButton';

function RemoveGroupMembershipButton(props) {
  const groupable = groupUtils(props.loggedUser, props.group);

  return (
    <ActionButton {...props}
                  action={groupable.removeGroupMembership}
    />
  );
}

export { RemoveGroupMembershipButton as default };
