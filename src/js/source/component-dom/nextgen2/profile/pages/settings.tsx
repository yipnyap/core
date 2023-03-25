import React from 'react';
import ReactDOM from 'react-dom';
import {router} from "../../../../../../nextgen2";
import {RouterProvider} from "react-router-dom";
let NGSettingsPageElement: Element | null;
NGSettingsPageElement = document.querySelector('#nextgen-settings-page');

if (NGSettingsPageElement) {
    ReactDOM.render(
        <RouterProvider router={router} />,
        NGSettingsPageElement
    );
}
