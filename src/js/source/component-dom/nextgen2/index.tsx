import React from 'react';
import ReactDOM from 'react-dom';
import {router} from "@nextgen2";
import {RouterProvider} from "react-router-dom";

let NGActivityPageElement: Element | null;
NGActivityPageElement = document.querySelector('#ng2-entrypoint');

/**
 * Global variable init
 */
// Populate the current user to the global "yipnyap_constants" object
import {populateCurrentUser} from './global/user';

populateCurrentUser().then(async r => {
    if (NGActivityPageElement) {
        ReactDOM.render(
            <RouterProvider router={router}/>,
            NGActivityPageElement
        );
    }

    /**
     * Profile DOM
     */
    await import('./profile/header');
});