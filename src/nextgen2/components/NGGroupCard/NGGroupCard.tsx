import React, {useEffect, useState} from 'react';
// @ts-ignore
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
import {PlusIcon} from "@heroicons/react/20/solid";

interface Group {
    name?: string;
    description?: string;
    banner?: string;
    avatar?: string;
    member_count?: number;
    posts?: number;
}

export declare interface NGGroupCardType {
    group: string | Group;

    theme?: any;
    children?: React.ReactNode;
}

export const NGGroupCardTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGGroupCard({...props}: NGGroupCardType) {
    let theme = buildClassObject(NGGroupCardTheming, props.theme || undefined);
    const [group, setGroup] = useState<Group>(typeof props.group !== 'string' ? props.group : {});

    return (
        <div className="flex flex-col rounded-default bg-box highlight-white/5">
            {/* Banner */}
            <div className="w-full h-52 rounded-default bg-box" style={{
                background: `url(${group.banner}) no-repeat center center/cover`,
            }}></div>

            <div className="space-y-4 justify-between items-center px-4 py-2">
                <div className="flex flex-row items-center space-x-2">
                    <div className="w-8 h-8 rounded-full bg-box" style={{
                        background: `url(${group.avatar}) no-repeat center center/cover`,
                    }}></div>
                    <div className="flex flex-col">
                        <h3 className="text-lg">{group.name}</h3>
                        <p className="text-sm text-neutral-500">{group.description}</p>
                    </div>
                </div>

                <div className="flex flex-row">
                    <div className="flex flex-row flex-grow items-center space-x-2">
                        <div className="flex flex-col">
                            <p className="text-sm text-neutral-500">Members</p>
                            <p className="text-sm">{group.member_count}</p>
                        </div>
                    </div>
                    {/* Join button icon */}
                    <button
                        className="flex flex-row items-center justify-center w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-700">
                        <PlusIcon className="w-4 h-4 text-white"/>
                    </button>
                </div>
            </div>
        </div>
    );
}
