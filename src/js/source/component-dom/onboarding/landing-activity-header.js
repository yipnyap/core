import React from 'react';
import ReactDOM from 'react-dom';
import NoUserCTAActivity from "../../component/onboarding/NoUserCTAActivity";

const loggedOutLandingElement = document.querySelector('#cmui-landing-activity-header');

if (loggedOutLandingElement) {
    const postCount = Number.parseInt(loggedOutLandingElement.getAttribute('data-postcount'), 10) || false,
        userCount = Number.parseInt(loggedOutLandingElement.getAttribute('data-usercount'), 10) || false,
        groupCount = Number.parseInt(loggedOutLandingElement.getAttribute('data-groupcount'), 10) || false;

    ReactDOM.render(
        <NoUserCTAActivity
            posts={postCount}
            users={userCount}
            groups={groupCount}
        />,
        loggedOutLandingElement
    );
}
