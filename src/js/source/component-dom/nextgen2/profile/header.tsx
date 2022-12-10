import React from 'react';
import ReactDOM from 'react-dom';
import {router} from "../../../component/nextgen2";
import {RouterProvider} from "react-router-dom";

let NGProfileHeaderElement: Element | null;
NGProfileHeaderElement = document.querySelector('#nextgen-profile-header');
document.body.style.overflow = 'hidden';

if (NGProfileHeaderElement) {
    const userID = NGProfileHeaderElement.getAttribute('data-userid') || false;
    ReactDOM.render(
        <RouterProvider router={router} />,
        NGProfileHeaderElement
    );
}
