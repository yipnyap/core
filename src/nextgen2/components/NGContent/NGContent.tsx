import React, {useEffect, useState} from 'react';
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";

export declare interface NGContentType {
    heading: {
        heading: string | JSX.Element | null;
        bold?: boolean;
        padding?: boolean;
        fullHeight?: boolean;
    }

    srHeading: string; // Used for screen readers

    theme?: any;
    children?: React.ReactNode;
}

export const NGContentTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGContent({...props}: NGContentType) {
    let theme = buildClassObject(NGContentTheming, props.theme || undefined)

    if (!props.srHeading) throw new Error('NG_SR_CANT_READ: always provide a srHeading prop for screen readers')

    let isHeading = typeof props.heading?.heading === 'string';

    typeof props.heading?.padding === 'undefined' && (props.heading.padding = true)
    typeof props.heading?.bold === 'undefined' && (props.heading.bold = true)
    typeof props.heading?.fullHeight === 'undefined' && (props.heading.fullHeight = true)

    return (
        <div id="NGContent" className={`${(location.pathname === '/') && 'hidden sm:block'} flex-1 overflow-y-auto`}>
            <div aria-labelledby="primary-heading" className={
                (props.heading?.padding ? 'max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8' : '')
                + ' mb-48 ' + (props.heading?.fullHeight ? 'h-full' : '')
            }>
                <h1 id="primary-heading" className="sr-only">
                    {props.srHeading}
                </h1>

                {(props.heading && isHeading) && (
                    <h1 className={`text-3xl ${props.heading.bold ? 'font-extrabold' : ''} text-neutral-900 dark:text-white`}>{props.heading.heading}</h1>
                )}

                {(props.heading && !isHeading) && (
                    <div className={`text-3xl ${props.heading.bold ? 'font-extrabold' : ''} text-neutral-900 dark:text-white`}>{props.heading.heading}</div>
                )}

                <div className={`${isHeading ? 'mt-6 space-y-8' : ''} h-full`}>
                    {props.children}
                </div>
            </div>
        </div>
    );
}
