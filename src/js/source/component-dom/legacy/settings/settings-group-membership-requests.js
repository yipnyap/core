import React from 'react';
import ReactDOM from 'react-dom';

import GroupMembershipRequestsSettingsScreen from '../../../component/legacy/settings/GroupMembershipRequestsSettingsScreen';

const groupMembershipRequestsSettingsElement = document.querySelector('#group-membership-requests-settings-screen');

if (groupMembershipRequestsSettingsElement) {
  ReactDOM.render(
    <GroupMembershipRequestsSettingsScreen />,
    groupMembershipRequestsSettingsElement
  );
}
