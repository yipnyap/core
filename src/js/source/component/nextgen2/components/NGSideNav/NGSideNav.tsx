import React, {Fragment, useState} from 'react';
import {buildClassObject} from "../../utils/ColourScheme.utils";
import {Dialog, Transition} from "@headlessui/react";
import {Bars3Icon, XMarkIcon} from "@heroicons/react/24/outline";
import {ChevronLeftIcon} from "@heroicons/react/24/solid";
import {NGContentNavigator} from "../NGContentNavigator";
import {NGContentNavigatorItemType} from "../NGContentNavigator/NGContentNavigator";
import {NavLink} from "react-router-dom";

interface NGSideNavItemType {
    name: string;
    href: string;
    icon: ((props: React.SVGProps<SVGSVGElement>) => JSX.Element) | string;
}

export declare interface NGSideNavType {
    items: NGSideNavItemType[] | null;
    showContentNavigator?: boolean;
    slimContentNavigator?: boolean;
    contentNavigatorItems?: NGContentNavigatorItemType[];
    contentNavigatorHeading?: string | null;
    logoURL?: string;
    theme?: any;
    children?: React.ReactNode;
}

export declare interface NGUserType {
    loggedIn: boolean;
    username?: string;
    id?: string;
    pictures?: {
        profile?: {
            url?: string;
        }
    }
}

export const NGSideNavTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGSideNav({...props}: NGSideNavType) {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [user, setUser] = useState<NGUserType>({loggedIn: false});
    let theme = buildClassObject(NGSideNavTheming, props.theme || undefined);

    const logoURL = props.logoURL || 'https://yipnyap.xyz/vault/@server/uploads/2022/04/cropped-yipnyap-logo.png'

    return (
        <>
            {
                props.items !== null && (
                    <>
                        {/* Mobile Sidenav Menu */}
                        <Transition.Root show={mobileMenuOpen} as={Fragment}>
                            <Dialog as="div" className="fixed inset-0 flex z-40 lg:hidden" onClose={setMobileMenuOpen}>
                                <Transition.Child
                                    as={Fragment}
                                    enter="transition-opacity ease-linear duration-300"
                                    enterFrom="opacity-0"
                                    enterTo="opacity-100"
                                    leave="transition-opacity ease-linear duration-300"
                                    leaveFrom="opacity-100"
                                    leaveTo="opacity-0"
                                >
                                    <Dialog.Overlay className="fixed inset-0 bg-blue-gray-600 bg-opacity-75" />
                                </Transition.Child>
                                <Transition.Child
                                    as={Fragment}
                                    enter="transition ease-in-out duration-300 transform"
                                    enterFrom="-translate-x-full"
                                    enterTo="translate-x-0"
                                    leave="transition ease-in-out duration-300 transform"
                                    leaveFrom="translate-x-0"
                                    leaveTo="-translate-x-full"
                                >
                                    <div className="relative flex-1 flex flex-col max-w-xs w-full bg-white focus:outline-none">
                                        <Transition.Child
                                            as={Fragment}
                                            enter="ease-in-out duration-300"
                                            enterFrom="opacity-0"
                                            enterTo="opacity-100"
                                            leave="ease-in-out duration-300"
                                            leaveFrom="opacity-100"
                                            leaveTo="opacity-0"
                                        >
                                            <div className="absolute top-0 right-0 -mr-12 pt-4">
                                                <button
                                                    type="button"
                                                    className="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                                    onClick={() => setMobileMenuOpen(false)}
                                                >
                                                    <span className="sr-only">Close sidebar</span>
                                                    <XMarkIcon className="h-6 w-6 text-white" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </Transition.Child>
                                        <div className="pt-5 pb-4">
                                            <div className="flex-shrink-0 flex items-center px-4">
                                                <img
                                                    className="h-8 w-auto rounded-lg"
                                                    src={logoURL}
                                                    alt="Yipnyap"
                                                />
                                            </div>
                                            <nav aria-label="Sidebar" className="mt-5">
                                                <div className="px-2 space-y-1">
                                                    {props.items.map((item) => (
                                                        <NavLink
                                                            key={item.name}
                                                            to={item.href}
                                                            className="group p-2 cursor-pointer rounded-lg flex items-center text-base font-medium text-blue-gray-600 hover:bg-blue-gray-50 hover:text-blue-gray-900"
                                                        >
                                                            { typeof item.icon !== 'string' && (
                                                                <>
                                                                    <item.icon
                                                                        className="mr-4 h-6 w-6 text-blue-gray-400 group-hover:text-blue-gray-500"
                                                                        aria-hidden="true"
                                                                    />
                                                                    {item.name}
                                                                </>
                                                            )}

                                                            { typeof item.icon === 'string' && (
                                                                <>
                                                                    <img
                                                                        className="mr-4 h-6 w-6 rounded-lg"
                                                                        src={item.icon}
                                                                    />
                                                                    {item.name}
                                                                </>
                                                            )}
                                                        </NavLink>
                                                    ))}
                                                </div>
                                            </nav>
                                        </div>
                                        {user.loggedIn && (
                                            <div className="flex-shrink-0 flex border-t border-blue-gray-200 p-4">
                                                <NavLink to='/@me' className="cursor-pointer flex-shrink-0 group block">
                                                    <div className="flex items-center">
                                                        <div>
                                                            <img
                                                                className="inline-block h-10 w-10 rounded-full"
                                                                src={user?.pictures?.profile?.url || '/img/default-avatar.png'}
                                                                alt=""
                                                            />
                                                        </div>
                                                        <div className="ml-3">
                                                            <p className="text-base font-medium text-blue-gray-700 group-hover:text-blue-gray-900">
                                                                {user.username}
                                                            </p>
                                                            <p className="text-sm font-medium text-blue-gray-500 group-hover:text-blue-gray-700">
                                                                Account Settings
                                                            </p>
                                                        </div>
                                                    </div>
                                                </NavLink>
                                            </div>
                                        )}
                                    </div>
                                </Transition.Child>
                                <div className="flex-shrink-0 w-14" aria-hidden="true">
                                    {/* Force sidebar to shrink to fit close icon */}
                                </div>
                            </Dialog>
                        </Transition.Root>

                        {/* Static sidebar for desktop */}
                        <div className="hidden lg:flex lg:flex-shrink-0">
                            <div className="flex flex-col w-20">
                                <div className="flex-1 flex flex-col min-h-0 overflow-y-auto bg-blue-600 dark:bg-blue-700">
                                    <div className="flex-1">
                                        <div className="bg-blue-700 py-4 flex items-center justify-center dark:bg-blue-800">
                                            <img
                                                className="h-8 w-auto rounded-lg"
                                                src={logoURL}
                                                alt="Yipnyap"
                                            />
                                        </div>
                                        <nav aria-label="Sidebar" className="py-6 flex flex-col items-center space-y-3">
                                            {props.items.map((item) => (
                                                <NavLink
                                                    key={item.name}
                                                    to={item.href}
                                                    className="flex cursor-pointer items-center p-4 rounded-lg text-blue-200 hover:bg-blue-700"
                                                >
                                                    { typeof item.icon !== 'string' && (
                                                        <item.icon className="h-6 w-6" aria-hidden="true" />
                                                    )}

                                                    { typeof item.icon === 'string' && (
                                                        <img
                                                            className="h-6 w-6 rounded-lg"
                                                            src={item.icon}
                                                        />
                                                    )}
                                                    <span className="sr-only">{item.name}</span>
                                                </NavLink>
                                            ))}
                                        </nav>
                                    </div>
                                    {user.loggedIn && (
                                        <div className="flex-shrink-0 flex pb-5">
                                            <NavLink to='/@me' className="cursor-pointer flex-shrink-0 w-full">
                                                <img
                                                    className="block mx-auto h-10 w-10 rounded-full"
                                                    src={user?.pictures?.profile?.url || '/img/default-avatar.png'}
                                                    alt=""
                                                />
                                                <div className="sr-only">
                                                    <p>{user.username}</p>
                                                    <p>Account settings</p>
                                                </div>
                                            </NavLink>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    </>
                )
            }
            {/* Content area */}
            <div id="NGContentArea" className="flex-1 min-w-0 flex flex-col overflow-hidden">
                {/* Mobile top navigation */}
                {
                    false && (
                        <div className="lg:hidden">
                            <div className="bg-blue-600 py-2 px-4 flex items-center justify-between sm:px-6">
                                <div>
                                    <img
                                        className="h-8 w-auto rounded-lg"
                                        src={logoURL}
                                        alt="Yipnyap"
                                    />
                                </div>
                                <div>
                                    <button
                                        type="button"
                                        className="-mr-3 h-12 w-12 inline-flex items-center justify-center bg-blue-600 rounded-lg text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                        onClick={() => setMobileMenuOpen(true)}
                                    >
                                        <span className="sr-only">Open sidebar</span>
                                        <Bars3Icon className="h-6 w-6" aria-hidden="true" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    )
                }
                <main className="flex-1 flex overflow-hidden">
                    <div className="flex-1 flex flex-col overflow-hidden">
                        {/* Breadcrumb */}
                        {location.pathname !== '/home/' && (
                            <nav aria-label="Breadcrumb" className="bg-white border-b border-blue-gray-200 dark:bg-neutral-800 dark:border-neutral-600">
                                <div className="max-w-3xl mx-auto py-3 px-4 flex items-start sm:px-6 lg:px-8">
                                    <a
                                        href="/home/"
                                        className="-ml-1 cursor-pointer inline-flex items-center space-x-3 text-sm font-medium text-blue-gray-900 dark:text-neutral-50"
                                    >
                                        <ChevronLeftIcon className="h-5 w-5 text-blue-gray-400 dark:text-neutral-400"
                                                         aria-hidden="true"/>
                                        <span>Detach</span>
                                    </a>
                                </div>
                            </nav>
                        )}

                        <div className="flex-1 flex overflow-hidden">
                            {/* Content Navigator */}
                            {props.showContentNavigator && (
                                // @ts-ignore
                                <NGContentNavigator slimContentNavigator={props.slimContentNavigator || false} items={props.contentNavigatorItems || []} heading={props.contentNavigatorHeading}/>
                            )}
                            {/* Main content */}
                            {props.children}
                        </div>
                    </div>
                </main>
            </div>
        </>
    );
}
