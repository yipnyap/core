import {SparklesIcon} from '@heroicons/react/20/solid';
import React from 'react';
import {buildClassObject} from '@nextgen2/utils/ColourScheme.utils';
import {NavLink} from 'react-router-dom';
import {HomeIcon} from '@heroicons/react/24/solid';

export declare interface NGContentNavigatorItemType {
    name: string | JSX.Element;
    description: string;
    href: string;
    target?: string;
    current?: boolean;
    new?: boolean;
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

    props.items.length === 0 && (
        props.items = [{
            name: 'Home',
            description: '',
            href: '/',
            icon: HomeIcon,
        }]
    );

    return (
        <>
            <nav
                aria-label="Sections"
                className={`hidden lg:flex lg:flex-col ${slimNavClass} flex-shrink-0 bg-sidebar-default/75 dark:bg-sidebar-dark/75 backdrop-blur-lg border-0 border-r border-solid border-default overflow-y-auto`}>
                {!props.slimContentNavigator && (
                    <div
                        className="flex-shrink-0 h-16 px-6 border-b border-blue-gray-200 flex items-center dark:border-neutral-600">
                        <p className="text-lg font-medium text-blue-gray-900 dark:text-white">{props.heading || location.pathname.split('/')[1] || 'Home'}</p>
                    </div>
                )}
                <div className="flex-1 min-h-0 overflow-y-auto no-scrollbar">
                    {props.items.map((item, i) => (
                        <NavLink
                            key={i}
                            to={item.href}
                            target={item.target}
                            className={({isActive}) => (
                                isActive ? 'bg-blue-50 bg-opacity-50 dark:bg-neutral-700' : 'hover:bg-blue-50 hover:bg-opacity-50 dark:hover:bg-neutral-700'
                            ) + ' flex p-6 border-b border-blue-gray-200 dark:border-neutral-600 cursor-pointer'}
                            end
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
                                    <div className="flex items-center">
                                        <p className="font-medium text-blue-gray-900 dark:text-neutral-50">{item.name}</p>
                                        {item.new && (
                                            <div
                                                className="ml-2 inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full bg-blue-100">
                                                <SparklesIcon className="h-4 w-4 text-blue-400"
                                                              aria-hidden="true"/>
                                                <span className="text-xs font-medium text-blue-800">
                                                    New!
                                                </span>
                                            </div>
                                        )}
                                    </div>
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
                className={`fixed lg:hidden flex flex-row flex-shrink-0 bg-box w-full z-10 bottom-0 left-0 border-t border-x-0 border-b-0 border-solid border-default rounded-tl-xl rounded-tr-xl overflow-x-auto no-scrollbar`
                    // Dark mode
                    + ` dark:border-neutral-600`}>
                {props.items.map((item, i) => (
                    <NavLink
                        key={i}
                        to={item.href}
                        target={item.target}
                        className={({isActive}) => (
                            isActive ? 'bg-blue-50 bg-opacity-50 dark:bg-neutral-700' : 'hover:bg-blue-50 hover:bg-opacity-50 dark:hover:bg-neutral-700'
                        ) + ' flex p-6 border-b border-blue-gray-200 dark:border-neutral-600 cursor-pointer'}
                        end
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
