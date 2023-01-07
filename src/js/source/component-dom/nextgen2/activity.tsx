import React from 'react';
import ReactDOM from 'react-dom';
import {router} from "../../component/nextgen2";
import {RouterProvider} from "react-router-dom";

let NGActivityPageElement: Element | null;
NGActivityPageElement = document.querySelector('#ng2-activity');

if (NGActivityPageElement) {
    document.body.style.overflow = 'hidden';
    ReactDOM.render(
        <RouterProvider router={router} />,
        NGActivityPageElement
    );
}
