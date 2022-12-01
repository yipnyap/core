import React, {useState} from 'react';
import {buildClassObject} from "../../utils/ColourScheme.utils";

export declare interface NGBodyType {
    theme?: any;
    children?: React.ReactNode;
}

export const NGBodyTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGBody({...props}: NGBodyType) {
    let theme = buildClassObject(NGBodyTheming, props.theme || undefined)

    return (
        <div className="h-screen flex overflow-none">
            {props.children}
        </div>
    );
}
