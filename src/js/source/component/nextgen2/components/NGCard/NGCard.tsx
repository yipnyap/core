import React from 'react';
import {buildClassObject} from "../../utils/ColourScheme.utils";

export declare interface NGCardType {
    title?: undefined | string | React.ReactNode;
    wellBody?: boolean;

    className?: string;
    theme?: any;
    children?: React.ReactNode;
}

export const NGCardTheming = {
    all: ['px-4', 'py-5', 'sm:px-6'],
    main: ['bg-box-solid', 'flex', 'flex-col', 'rounded-xl', 'highlight-white/5'],
    card: {
        header: ['text-ColourScheme-900', 'dark:text-white'],
        body: ['dark:text-ColourScheme-300'],
        wellBody: {
            // header: ['divide-ColourScheme-200', 'dark:divide-ColourScheme-600'],
            body: ['bg-box-alt', 'rounded-xl'],
        }
    }
};

export default function NGCard({...props}: NGCardType) {
    let theme = buildClassObject(NGCardTheming, props.theme || undefined, 'card', (props.wellBody ? 'wellBody' : undefined))

    return (
        <div className={`${theme.main} ${props.className}`}>
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
