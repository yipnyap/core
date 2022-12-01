import React from 'react';
import ReactDOM from 'react-dom';

import {NGProfileHeader} from '../../nextgen/components/NGProfileHeader';

const NGProfileHeaderElement = document.querySelector('#nextgen-profile-header');

if (NGProfileHeaderElement) {
    const userID = NGProfileHeaderElement.getAttribute('data-userid') || false;

    ReactDOM.render(
        <NGProfileHeader user={userID}/>,
        NGProfileHeaderElement
    );
}
