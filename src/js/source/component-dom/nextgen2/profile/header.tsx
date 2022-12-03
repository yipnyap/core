import React from 'react';
import ReactDOM from 'react-dom';

import Profile from '../../../component/nextgen2/profile';

let NGProfileHeaderElement: Element | null;
NGProfileHeaderElement = document.querySelector('#nextgen-profile-header');

if (NGProfileHeaderElement) {
    const userID = NGProfileHeaderElement.getAttribute('data-userid') || false;
    ReactDOM.render(
        <Profile
            userID={userID}
        />,
        NGProfileHeaderElement
    );
}
