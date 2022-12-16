import React from 'react';
import ReactDOM from 'react-dom';

import HeaderNotifications from '../../../component/legacy/header/HeaderNotifications';

const headerNotificationsElement = document.querySelector('#header-notifications');

if (headerNotificationsElement) {
  ReactDOM.render(
    <HeaderNotifications />,
    headerNotificationsElement
  );
}
