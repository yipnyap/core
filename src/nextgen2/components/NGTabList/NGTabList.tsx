import React, {useEffect, useState} from 'react';
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";

export declare interface NGTabListItemType {
    name: string;
    current?: boolean;
    children?: React.ReactNode;
}

export declare interface NGTabListType {
    theme?: any;
    children?: React.ReactNode;

    srLabel: string;
    tabs: NGTabListItemType[];
    style?: 'fill' | 'outline:bleed'
}

export const NGTabListTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGTabList({...props}: NGTabListType) {
    let theme = buildClassObject(NGTabListTheming, props.theme || undefined);
    const [current, setCurrent] = useState<NGTabListItemType>(props.tabs.find(tab => tab.current) || props.tabs[0]);

    useEffect(() => {
      setCurrent(props.tabs.find(tab => tab.current) || props.tabs[0]);
    }, [props.tabs]);
    return (
        <>
            <div className="mt-4">
                <div className="sm:hidden">
                    <label htmlFor="tabs" className="sr-only">
                        Select a Feed Filter
                    </label>
                    {/* Use an "onChange" listener to redirect the user to the selected tab URL. */}
                    <select
                        id="tabs"
                        name="tabs"
                        className="block w-full focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-lg"
                        defaultValue={props.tabs.find((tab) => tab.current)?.name}
                    >
                        {props.tabs.map((tab) => (
                            <option key={tab.name}>{tab.name}</option>
                        ))}
                    </select>
                </div>
                <div className="hidden sm:block">
                    <nav className="flex space-x-4" aria-label="Tabs">
                        {props.tabs.map((tab) => (
                            <div
                                key={tab.name}
                                className={classNames(
                                    tab.name === current.name ? `${props.style === 'outline:bleed' ? 'border-x border-t !rounded-b-none border-default' : 'bg-neutral-100 dark:bg-neutral-700'} text-neutral-700 dark:text-white` : 'text-neutral-500 hover:text-neutral-600',
                                    'px-3 py-2 font-medium text-sm rounded-lg cursor-pointer'
                                )}
                                onClick={() => setCurrent(tab)}
                                aria-current={tab.name === current.name ? 'page' : undefined}
                            >
                                {tab.name}
                            </div>
                        ))}
                    </nav>
                </div>
            </div>

            <div className={`${props.tabs.indexOf(current) === 0 ? 'rounded-tl-none' : ''} !mt-0 p-4 ${props.style?.startsWith('outline') ? 'border border-default' : ''} rounded-lg`}>
                {
                    current?.children
                }
            </div>
        </>
    );
}
