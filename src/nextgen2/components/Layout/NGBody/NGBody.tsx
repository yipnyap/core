import React, {useState} from 'react';
import {buildClassObject} from '@nextgen2/utils/ColourScheme.utils';
import {useHeading} from '@nextgen2/providers/PageHeading.provider';

export declare interface NGBodyType {
    theme?: any;
    children?: React.ReactNode;
    className?: string;
}

export const NGBodyTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGBody({...props}: NGBodyType) {
    let theme = buildClassObject(NGBodyTheming, props.theme || undefined);
    const [heading] = useHeading();

    return (
        <div
            className="justify-center m-auto h-full">
            <div
                className={`flex flex-col p-8 pt-10 pb-48 md:px-20 space-y-12 h-full overflow-y-auto overflow-x-hidden ${props.className}`}>
                {props.children}
            </div>

        </div>
    );
}
