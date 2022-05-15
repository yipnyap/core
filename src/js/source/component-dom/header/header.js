import React from 'react';
import ReactDOM from 'react-dom';

import Header from '../../component/header/Header';

const headerElement = document.querySelector('#cmui-header');

if (headerElement) {
    ReactDOM.render(
        <Header />,
        headerElement
    );
}
