import React from 'react';
import {buildClassObject} from "../../utils/ColourScheme.utils";

export declare interface NGCardType {
    title?: undefined | string | React.ReactNode;
    wellBody?: boolean;

    theme?: any;
    children?: React.ReactNode;
}

export const NGCardTheming = {
    all: ['px-4', 'py-5', 'sm:px-6'],
    main: ['bg-white', 'overflow-hidden', 'shadow', 'rounded-lg', 'divide-y', 'dark:bg-ColourScheme-800', 'divide-ColourScheme-200', 'dark:divide-ColourScheme-700'],
    card: {
        header: ['text-ColourScheme-900', 'dark:text-white'],
        body: ['dark:text-ColourScheme-300'],
        wellBody: {
            // header: ['divide-ColourScheme-200', 'dark:divide-ColourScheme-600'],
            body: ['bg-ColourScheme-50', 'dark:bg-ColourScheme-700'],
        }
    }
};

export default function NGCard({...props}: NGCardType) {
    let theme = buildClassObject(NGCardTheming, props.theme || undefined, 'card', (props.wellBody ? 'wellBody' : undefined))

    return (
        <div className={`${theme.main}`}>
            {props.title && (
                <div className={`${theme.all} ${theme.card?.header}`}>
                    {props.title}
                </div>
            )}
            {props.children && (
                <div className={`${theme.all} ${theme.card?.body}`}>
                    {props.children}
                </div>
            )}
        </div>
    );
}
