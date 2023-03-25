import React from 'react';

import groupUtils from '@legacy/component/utils/group';

import ActionButton from '../ActionButton';

function LeaveGroupButton(props) {
  const groupable = groupUtils(props.loggedUser, props.group);

  return (
    <ActionButton {...props}
                  action={groupable.leaveGroup}
    />
  );
}

export { LeaveGroupButton as default };
