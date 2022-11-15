// noinspection JSVoidFunctionReturnValueUsed

import React, {Fragment, useEffect, useState} from 'react';
import {Dialog, Transition} from '@headlessui/react';
import {Bars3Icon, BellIcon, XMarkIcon, MoonIcon} from '@heroicons/react/24/outline';

import * as userRouter from "../../router/user/user-router";
import HeaderDropdownNotifications from "./header-dropdown/header-dropdown-notifications/HeaderDropdownNotifications";

let changingColorTheme = false;

let navigation = [];
let userNavigation = [];
let userNavigationMobile = [];

function toggleLoggedUserColorTheme(e) {
    // if already changing color theme, return
    if (changingColorTheme) {
        return;
    }

    changingColorTheme = true;

    const toggleLoggedUserColorThemePromise = userRouter.toggleLoggedUserColorTheme();

    toggleLoggedUserColorThemePromise
        .done((response) => {
            console.log('TOGGLE LOGGED USER COLOR THEME - RESPONSE', response);
        })
        .fail((error) => {
            console.log('TOGGLE LOGGED USER COLOR THEME - ERROR', error);
        })
        .always(() => {
            window.location.reload();
        });
}

function classNames(...classes) {
    return classes.filter(Boolean).join(' ');
}

export default function Header() {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [loggedUser, setLoggedUser] = useState(false);
    const [loadingUser, setLoadingUser] = useState(true);

    function populateUserLocalStorageCache() {
        userRouter.getLoggedInMember()
            .done((res) => {
                console.debug('[COMMUNITY UI 1] Debug user fetch - response', res);

                userNavigationMobile = [
                    {name: 'Home', href: '/'},
                    {name: 'Members', href: '/members'},
                    {name: 'Groups', href: '/groups'}
                ];

                if (res === false) {
                    setLoadingUser(false);

                    userNavigationMobile = [
                        {name: 'Sign In', href: '/register'},
                        {name: 'Sign Up', href: '/login'}
                    ]

                    return localStorage.setItem('user-profile-cache', JSON.stringify({error: 'ERRT-3011'}))
                }

                setLoggedUser(res);
                localStorage.setItem('user-profile-cache', JSON.stringify(res));

                navigation = [
                    {name: 'Your Profile', href: `${res.link}`, children: []},
                    {name: 'Notifications', href: `${res.link}settings/notifications`, children: []},
                    // {name: 'Messages', beta: true, href: `${res.link}settings/messages`, children: []},
                    {name: 'Friend Requests', href: `${res.link}settings/friend-requests`, children: []},
                    {border: true},
                    {
                        name: 'Your Groups', href: `${res.link}groups`, children: [
                            {name: 'Send Invites', href: `${res.link}settings/send-group-invitations`},
                            {name: 'Received Invites', href: `${res.link}settings/received-group-invitations`},
                            {name: 'Join Requests', href: `${res.link}settings/membership-requests`},
                            {name: 'Manage', href: `${res.link}settings/manage-groups`},
                        ]
                    },
                    // {border: true},
                    // {
                    //     name: 'Account & Security', href: `${res.link}settings/account`, children: [
                    //         {name: 'Password', href: `${res.link}settings/password`},
                    //         {name: 'Email', href: `${res.link}settings/email-settings`},
                    //         // {name: 'Deactivate', href: `${res.link}settings/password`, danger: true},
                    //     ]
                    // },
                    {border: true},
                    {
                        name: 'User Settings',
                        href: `${res.link}settings/`,
                        children: [
                            {name: 'Edit Profile', href: `${res.link}settings/`},
                            {name: 'Manage Kukiko ID', href: `${res.link}settings/account-settings`},
                        ],
                    },
                    {border: true},
                ];

                setLoadingUser(false);
            })
            .fail((res) => {
                console.debug('[COMMUNITY UI 1] User fetch - fail', res);
            });
    }

    useEffect(() => {
        populateUserLocalStorageCache();
    }, []);

    return (
        <header className="flex-shrink-0 relative h-16 flex items-center lg:pl-24"
                style={{background: 'var(--color-header-background)'}}
        >
            <a href="/" className="flex-grow inset-0 left-0 pl-4 items-center sm:pl-6 lg:hidden">
                <img src={yipnyap_constants.logo_url} alt="Yipnyap"
                     className="h-8 w-auto inline-flex items-center justify-center rounded-default"/>
            </a>
            {/* Menu button area */}
            <div className="inset-y-0 right-0 pr-4 flex items-center sm:pr-6 md:hidden">
                {/* Mobile menu button */}
                <button
                    type="button"
                    className="-mr-2 inline-flex items-center justify-center p-2 rounded-default text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    onClick={() => setMobileMenuOpen(true)}
                >
                    <span className="sr-only">Open main menu</span>
                    <Bars3Icon className="block h-6 w-6" aria-hidden="true"/>
                </button>
            </div>

            {/* Desktop nav area */}
            <div className="hidden md:min-w-0 lg:flex-1 md:flex md:items-center md:justify-between">
                {/* Search */}
                {/*<div className="max-w-2xl relative text-neutral-400 focus-within:text-neutral-500">*/}
                {/*    <label htmlFor="search"*/}
                {/*           className="sr-only">*/}
                {/*        Search*/}
                {/*    </label>*/}
                {/*    <div className="mt-1 relative rounded-default shadow-sm">*/}
                {/*        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"*/}
                {/*             aria-hidden="true">*/}
                {/*            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"*/}
                {/*                 aria-hidden="true" className="mr-3 h-4 w-4 text-alt">*/}
                {/*                <path fillRule="evenodd"*/}
                {/*                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"*/}
                {/*                      clipRule="evenodd"></path>*/}
                {/*            </svg>*/}
                {/*        </div>*/}
                {/*        <input type="text" name="search" id="search" disabled className="highlight-main block w-full pl-9 max-h-9"*/}
                {/*               placeholder="Searching is disabled"/>*/}
                {/*    </div>*/}
                {/*</div>*/}

                <div className="relative"/>

                {/* Left nav area */}
                <div className="ml-10 pr-4 flex-shrink-0 flex items-center space-x-10">
                    {/* Navigation links */}
                    <nav aria-label="Global" className="flex space-x-10">
                        <a href="https://ko-fi.com/rekkisomo" target="_blank"
                           className="text-sm font-medium text-primary">
                            Ko-fi
                        </a>
                        <a href="https://yipnyap.atlassian.net/servicedesk" target="_blank"
                           className="text-sm font-medium text-primary">
                            Support & Feedback
                        </a>
                        <a href="/community-guidelines" className="text-sm font-medium text-primary">
                            Guidelines
                        </a>
                    </nav>

                    {(!loggedUser && !loadingUser) &&
                        <div className="flex items-center space-x-4">
                            <a href="/register" className="ypsdk button-upgrade inline-flex items-center">
                                Sign Up
                            </a>

                            <a href="/login" className="ypsdk button-upgrade inline-flex items-center"
                               color="primary">
                                Login
                            </a>
                        </div>
                    }

                    {/* User actions */}
                    {(loggedUser || loadingUser) &&
                        <div className="flex items-center space-x-8">
                            {/* Notifications */}
                            {(!loadingUser && loggedUser) &&
                                <HeaderDropdownNotifications loggedUser={loggedUser}/>
                            }

                            {/* Theme switcher */}
                            {
                                !loadingUser &&
                                <span className="inline-flex">
                                    <a href="#" onClick={toggleLoggedUserColorTheme}
                                       className="ypsdk button-icon -mx-1 p-1 rounded-full text-neutral-400 hover:text-neutral-500">
                                        <span className="sr-only">Toggle dark mode</span>
                                        <MoonIcon className="h-6 w-6" aria-hidden="true"/>
                                    </a>
                                </span>
                            }

                            {/* User menu */}
                            <button
                                className="flex items-center rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600"
                                onClick={() => !loadingUser ? setMobileMenuOpen(true) : () => {
                                }}>
                                <div className="flex-shrink-0">
                                    {/* Loading Spinner */}
                                    {loadingUser ?
                                        <svg className="animate-spin h-5 w-5 text-primary"
                                             xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor"
                                                    strokeWidth="4"></circle>
                                            <path className="opacity-75" fill="currentColor"
                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg> :
                                        <img className="h-8 w-8 rounded-full" src={loggedUser.avatar_url}
                                             alt=""/>
                                    }
                                </div>
                                <div className="text-left ml-3 min-w-0 flex-1">
                                    {
                                        !loadingUser ?
                                            <>
                                                <div
                                                    className="text-sm text-primary"
                                                >
                                                    {loggedUser.name}
                                                </div>
                                                <div
                                                    className="text-xs font-medium text-neutral-500"
                                                >
                                                    @{loggedUser.mention_name}
                                                </div>
                                            </> :
                                            <div className="animate-pulse">
                                                <div className="w-12 h-3 bg-box-over rounded"/>
                                                <div className="w-20 h-3 bg-box-over rounded mt-1"/>
                                            </div>
                                    }
                                </div>
                            </button>
                        </div>
                    }
                </div>
            </div>

            {/* Mobile menu, show/hide this `div` based on menu open/closed state */}
            <Transition.Root show={mobileMenuOpen} as={Fragment}>
                <Dialog
                    as="div"
                    static
                    className="fixed inset-0 z-40"
                    open={mobileMenuOpen}
                    onClose={setMobileMenuOpen}
                >
                    <Transition.Child
                        as={Fragment}
                        enter="transition-opacity ease-linear duration-300"
                        enterFrom="opacity-0"
                        enterTo="opacity-100"
                        leave="transition-opacity ease-linear duration-300"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                    >
                        <Dialog.Overlay
                            className="hidden sm:block sm:fixed sm:inset-0 sm:bg-neutral-600 sm:bg-opacity-75"/>
                    </Transition.Child>

                    <Transition.Child
                        as={Fragment}
                        enter="transition ease-out duration-150 sm:ease-in-out sm:duration-300"
                        enterFrom="transform opacity-0 scale-110 sm:translate-x-full sm:scale-100 sm:opacity-100"
                        enterTo="transform opacity-100 scale-100  sm:translate-x-0 sm:scale-100 sm:opacity-100"
                        leave="transition ease-in duration-150 sm:ease-in-out sm:duration-300"
                        leaveFrom="transform opacity-100 scale-100 sm:translate-x-0 sm:scale-100 sm:opacity-100"
                        leaveTo="transform opacity-0 scale-110  sm:translate-x-full sm:scale-100 sm:opacity-100"
                    >
                        <nav
                            className="fixed flex flex-col z-40 inset-0 h-full w-full bg-box sm:inset-y-0 sm:left-auto sm:right-0 sm:max-w-sm sm:w-full sm:shadow-lg"
                            aria-label="Global"
                        >
                            <div className="h-16 flex items-center justify-between px-4 sm:px-6">
                                <a href="/">
                                    <img
                                        className="block w-12"
                                        src={yipnyap_constants.logo_url}
                                        alt="Yipnyap Logo"
                                    />
                                </a>
                                <button
                                    type="button"
                                    className="-mr-2 inline-flex items-end justify-end p-2 rounded-default text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    <span className="sr-only">Close main menu</span>
                                    <XMarkIcon className="block h-6 w-6" aria-hidden="true"/>
                                </button>
                            </div>

                            {/* Top Account Section */}
                            <div className="pb-2 border-solid border-t-0 border-x-0 border-b-2 border-divider">
                                {(loggedUser && !loadingUser) &&
                                    <div className="max-w-8xl mx-auto px-4 flex items-center sm:px-6">
                                        <div className="flex-shrink-0">
                                            <img className="h-10 w-10 rounded-full" src={loggedUser.avatar_url}
                                                 alt=""/>
                                        </div>
                                        <a href={loggedUser.link} className="ml-3 min-w-0 flex-1">
                                            <div
                                                className="text-base font-medium text-primary truncate">{loggedUser.name}</div>
                                            <div
                                                className="text-sm font-medium text-neutral-500 truncate">@{loggedUser.mention_name}
                                            </div>
                                        </a>
                                        <a href={`${loggedUser.link}settings/notifications`}
                                           className="ml-auto flex-shrink-0 bg-box p-2 text-neutral-400 hover:text-neutral-500">
                                            <span className="sr-only">View notifications</span>
                                            <BellIcon className="h-6 w-6" aria-hidden="true"/>
                                        </a>
                                    </div>
                                }
                                <div className="mt-4 max-w-8xl mx-auto px-2 space-y-1 sm:px-4">
                                    {userNavigationMobile.map((item, i) => (
                                        <a
                                            key={i}
                                            href={item.href}
                                            className="header-menu-entity py-2 px-3 text-primary"
                                        >
                                            {item.name}
                                        </a>
                                    ))}
                                </div>
                            </div>

                            <div className="overflow-y-auto flex-grow">
                                {/* Additional Links */}
                                <div className="max-w-8xl mx-auto py-2">
                                    {navigation.map((item, i) =>
                                        (item.border) ? (
                                            <div key={i}
                                                 className="my-2 border-solid border-t-0 border-x-0 border-b-2 border-divider"/>
                                        ) : (
                                            <div key={i} className="px-2 sm:px-4">
                                                <a
                                                    href={item.href}
                                                    className="header-menu-entity py-2 px-3 text-primary"
                                                >
                                                    {item.name}

                                                    {item.beta && (
                                                        <span
                                                            className="ml-2 items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-white">
                                                    Beta
                                                </span>
                                                    )}
                                                </a>
                                                {item.children?.map((child) => (
                                                    <a
                                                        key={child.name}
                                                        href={child.href}
                                                        className="header-menu-entity py-2 pl-5 pr-3 text-base text-neutral-500"
                                                    >
                                                        {child.name}
                                                    </a>
                                                ))}
                                            </div>
                                        )
                                    )}
                                </div>
                            </div>
                            {/* Bottom Account Section */}
                            <div className="border-solid border-t-2 border-x-0 border-b-0 border-divider"
                                 style={{
                                     width: '-webkit-fill-available'
                                 }}>
                                <div className="max-w-8xl mx-auto py-2 px-2 space-y-1 sm:px-4">
                                    <span className="py-2 px-3 text-primary">
                                        Version: {yipnyap_constants.yipnyap_server_version}
                                    </span>
                                    <a className="header-menu-entity py-2 px-3 text-tertiary"
                                       href={yipnyap_constants.logout_url}
                                    >
                                        <span className="text-base font-medium">Sign Out</span>
                                    </a>
                                </div>
                            </div>
                        </nav>
                    </Transition.Child>
                </Dialog>
            </Transition.Root>
        </header>
    );
}
