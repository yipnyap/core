import React, {useState} from 'react';
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
import {useHeading} from "@nextgen2/providers/PageHeading.provider";

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
    let theme = buildClassObject(NGBodyTheming, props.theme || undefined);
    const [heading] = useHeading();

    return (
        <div
            className={`grid justify-center m-auto ${heading?.slimContentNavigator ? 'grid-cols-8 md:grid-cols-10' : 'grid-cols-6 md:grid-cols-8'} h-full`}>
            <div
                className={`flex flex-col ${heading?.slimContentNavigator ? 'col-span-8' : 'col-span-6'} p-8 md:px-20 md:py-10 space-y-12 h-full overflow-y-auto`}>
                {props.children}
            </div>
            <div
                className="hidden lg:flex flex-col sticky top-0 p-8 space-y-16 col-span-2 bg-sidebar border-0 border-l border-solid border-default dark:bg-sidebar-dark">
                {/* Top header text */}
                <h4 className="font-regular">Yipnyap is communicating...</h4>
                <div className="flex flex-col space-y-8"></div>
            </div>
        </div>
    );
}
