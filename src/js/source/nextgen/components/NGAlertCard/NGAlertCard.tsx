import React, {useState} from 'react';
import {buildClassObject} from "../../utils/ColourScheme.utils";
import {ExclamationTriangleIcon} from "@heroicons/react/20/solid";

export declare interface NGAlertCardType {
    body: string | React.ReactNode;

    theme?: any;
    children?: React.ReactNode;
}

export const NGAlertCardTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGAlertCard({...props}: NGAlertCardType) {
    let theme = buildClassObject(NGAlertCardTheming, props.theme || undefined)

    return (
        <div className="dark:border-gradient-red-dark p-4 -inset-px rounded-lg border-2 border-solid border-transparent">
            <div className="text-white flex space-x-4">
                <ExclamationTriangleIcon className="w-6" />
                {typeof props.body === 'string' ? <span>{props.body}</span> : props.body}
            </div>
        </div>
    );
}
