import React, {useState} from 'react';
// @ts-ignore
import {buildClassObject} from "../../utils/ColourScheme.utils";

export declare interface NGTemplateNameType {
    theme?: any;
    children?: React.ReactNode;
}

export const NGTemplateNameTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGTemplateName({...props}: NGTemplateNameType) {
    let theme = buildClassObject(NGTemplateNameTheming, props.theme || undefined)

    return (
        <div>
            {/* Some content */}
        </div>
    );
}
