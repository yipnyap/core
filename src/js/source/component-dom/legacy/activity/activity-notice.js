import React from 'react';
import ReactDOM from 'react-dom';

import ActivityNotice from '../../../component/legacy/activity-notice/activity-notice';

const activityNoticeElement = document.querySelector('#activity-notice');

if (activityNoticeElement) {
    ReactDOM.render(
        <ActivityNotice/>,
        activityNoticeElement
    );
}
