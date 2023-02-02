import React from 'react';
import {buildClassObject} from "../../utils/ColourScheme.utils";
import {NavLink} from "react-router-dom";
import {HomeIcon} from "@heroicons/react/24/outline";

export declare interface NGContentNavigatorItemType {
    name: string | JSX.Element;
    description: string;
    href: string;
    target?: string;
    current?: boolean;
    icon: ((props: React.SVGProps<SVGSVGElement>) => JSX.Element) | string;
}

export declare interface NGContentNavigatorType {
    slimContentNavigator: boolean;
    items: NGContentNavigatorItemType[];
    footer?: React.ReactNode;
    heading?: string | null;
    theme?: any;
    children?: React.ReactNode;
}

export const NGContentNavigatorTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGContentNavigator({...props}: NGContentNavigatorType) {
    let theme = buildClassObject(NGContentNavigatorTheming, props.theme || undefined);

    const slimNavClass = props.slimContentNavigator ? 'w-20' : 'w-96';

    props.items.length === 0 && (props.items = [{
        name: 'Home',
        description: '',
        href: '/',
        icon: HomeIcon,
        current: location.pathname === '/',
    }]);

    return (
        <>
            <nav
                aria-label="Sections"
                className={`${location.pathname === '/' ? `flex flex-col grow sm:grow-0` : 'hidden lg:flex lg:flex-col'} ${slimNavClass} flex-shrink-0 bg-box border-r border-blue-gray-200 overflow-y-auto`
                    // Dark mode
                    + ` dark:border-neutral-600`}>
                {!props.slimContentNavigator && (
                    <div
                        className="flex-shrink-0 h-16 px-6 border-b border-blue-gray-200 flex items-center dark:border-neutral-600">
                        <p className="text-lg font-medium text-blue-gray-900 dark:text-white">{props.heading || location.pathname.split('/')[1] || 'Home'}</p>
                    </div>
                )}
                <div className="flex-1 min-h-0 overflow-y-auto">
                    {props.items.map((item, i) => (
                        <NavLink
                            key={i}
                            to={item.href}
                            target={item.target}
                            className={classNames(
                                item.current ? 'bg-blue-50 bg-opacity-50 dark:bg-neutral-700' : 'hover:bg-blue-50 hover:bg-opacity-50 dark:hover:bg-neutral-700',
                                'flex p-6 border-b border-blue-gray-200 dark:border-neutral-600 cursor-pointer'
                            )}
                            aria-current={item.current ? 'page' : undefined}
                        >
                            {typeof item.icon !== 'string' && (
                                <item.icon className="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400"
                                           aria-hidden="true"/>
                            )}

                            {typeof item.icon === 'string' && (
                                <img
                                    className={`flex-shrink-0 -mt-0.5 h-6 w-6 ${item.description.startsWith('@') ? 'rounded-full' : 'rounded-lg'}`}
                                    src={item.icon}
                                    alt={`Icon for ${item.name}`}
                                />
                            )}
                            {!props.slimContentNavigator && (
                                <div className="ml-3 text-sm">
                                    <p className="font-medium text-blue-gray-900 dark:text-neutral-50">{item.name}</p>
                                    <p className="mt-1 text-blue-gray-500 dark:text-neutral-500">{item.description}</p>
                                </div>
                            )}
                        </NavLink>
                    ))}
                </div>
                {props.footer && (
                    <div
                        className="flex-shrink-0 h-16 text-sm text-default-alt border-t border-blue-gray-200 flex items-center dark:border-neutral-600">
                        {props.footer}
                    </div>
                )}
            </nav>

            {/* Bottom horizontal navigator */}
            <nav
                aria-label="Sections"
                className={`fixed lg:hidden flex flex-row flex-shrink-0 bg-box w-full bottom-0 left-0 border-t border-x-0 border-b-0 border-solid border-default rounded-tl-xl rounded-tr-xl overflow-x-auto`
                    // Dark mode
                    + ` dark:border-neutral-600`}>
                {props.items.map((item, i) => (
                    <NavLink
                        key={i}
                        to={item.href}
                        target={item.target}
                        className={classNames(
                            item.current ? 'bg-blue-50 bg-opacity-50 dark:bg-neutral-700' : 'hover:bg-blue-50 hover:bg-opacity-50 dark:hover:bg-neutral-700',
                            'flex p-6 border-b border-blue-gray-200 dark:border-neutral-600 cursor-pointer'
                        )}
                        aria-current={item.current ? 'page' : undefined}
                    >
                        {typeof item.icon !== 'string' && (
                            <item.icon className="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" aria-hidden="true"/>
                        )}

                        {typeof item.icon === 'string' && (
                            <div className="flex-shrink-0 -mt-0.5 h-6 w-6">
                                <img
                                    className={`h-6 w-6 ${item.description.startsWith('@') ? 'rounded-full' : 'rounded-lg'}`}
                                    src={item.icon}
                                    alt={`Icon for ${item.name}`}
                                />
                            </div>
                        )}
                    </NavLink>
                ))}
            </nav>
        </>

    );
}
