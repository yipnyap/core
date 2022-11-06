// noinspection JSVoidFunctionReturnValueUsed

import React, {Fragment, useEffect, useState} from 'react';
import {Dialog, Popover, Transition} from '@headlessui/react';
import {SearchIcon} from '@heroicons/react/solid';
import {
    BellIcon,
    MoonIcon,
    MenuIcon,
    XIcon,
    CogIcon,
    ShieldCheckIcon,
    UserGroupIcon, UserAddIcon, SupportIcon, LogoutIcon,
} from '@heroicons/react/outline';

import * as userRouter from "../../router/user/user-router";
import HeaderDropdownNotifications from "./header-dropdown/header-dropdown-notifications/HeaderDropdownNotifications";

let changingColorTheme = false;

let navigation = [];
let userNavigation = [];
let userNavigationMobile = [];
const callsToAction = [
    {name: 'Logout', href: yipnyap_constants.logout_url, icon: LogoutIcon},
    // TODO: Make this customisable
    {name: 'Support', href: 'https://yipnyap.atlassian.net/servicedesk/customer/portals', icon: SupportIcon},
];

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

                if (res === false) {
                    setLoadingUser(false);
                    return localStorage.setItem('user-profile-cache', JSON.stringify({error: 'ERRT-3011'}))
                }

                setLoggedUser(res);
                localStorage.setItem('user-profile-cache', JSON.stringify(res));

                userNavigationMobile = [
                    {name: 'Sign Out', href: yipnyap_constants.logout_url}
                ];

                userNavigation = [
                    {
                        name: 'Profile Customisation',
                        description: 'Customise your public profile, such as avatar and banners.',
                        href: `${res.link}settings`,
                        icon: CogIcon,
                    },
                    {
                        name: 'Groups',
                        description: 'Create groups, and manage one\'s you\'re moderating.',
                        href: `${res.link}settings/manage-groups`,
                        icon: UserGroupIcon,
                    },
                    {
                        name: 'Security',
                        description: "Manage your account's security settings, such as password.",
                        href: `${res.link}settings/password`,
                        icon: ShieldCheckIcon
                    },
                    {
                        name: 'Friends',
                        description: "Accept or deny friend requests from others.",
                        href: `${res.link}settings/friend-requests`,
                        icon: UserAddIcon,
                    },
                ];

                navigation = [
                    {
                        name: 'Profile',
                        href: `${res.link}settings/`,
                        children: [
                            {name: 'Social', href: `${res.link}settings/social`},
                            {name: 'Stream', href: `${res.link}settings/stream`},
                            {name: 'Notifications', href: `${res.link}settings/notifications`},
                        ],
                    },
                    {name: 'Messages', href: `${res.link}settings/messages`, children: []},
                    {name: 'Friends', href: `${res.link}settings/friend-requests`, children: []},
                    {
                        name: 'Account', href: `${res.link}settings/account-settings`, children: [
                            {name: 'Password', href: `${res.link}settings/password`},
                            {name: 'Email', href: `${res.link}settings/email`},
                        ]
                    },
                    {
                        name: 'Groups', href: `${res.link}groups`, children: [
                            {name: 'Manage', href: `${res.link}settings/manage-groups`},
                            {name: 'Send Invites', href: `${res.link}settings/send-group-invitations`},
                            {name: 'Invite Inbox', href: `${res.link}settings/received-group-invitations`},
                            {name: 'Join Requests', href: `${res.link}settings/membership-requests`},
                        ]
                    },
                ];

                // yes, this is spoofed, more to mimic a real socket connection
                // this is only temporary until we have a real socket connection!
                const min = Math.ceil(500);
                const max = Math.floor(3000);
                setTimeout(() => {
                    setLoadingUser(false);
                }, Math.floor(Math.random() * (max - min + 1)) + min);
            })
            .fail((res) => {
                console.debug('[COMMUNITY UI 1] User fetch - fail', res);
            });
    }

    useEffect(() => {
        populateUserLocalStorageCache();
    }, []);

    return (
        <header className="flex-shrink-0 relative h-16 flex items-center md:pl-24"
            style={{background: 'var(--color-header-background)'}}
        >
            <a href="/" className="flex-grow inset-0 left-0 pl-4 items-center sm:pl-6 md:hidden">
                <img src={yipnyap_constants.logo_url} alt="Yipnyap" className="h-8 w-auto inline-flex items-center justify-center rounded-default"/>
            </a>
            {/* Menu button area */}
            <div className="inset-y-0 right-0 pr-4 flex items-center sm:pr-6 md:hidden">
                {/* Mobile menu button */}
                <button
                    type="button"
                    className="-mr-2 inline-flex items-center justify-center p-2 rounded-default text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    onClick={() => setMobileMenuOpen(true)}
                >
                    <span className="sr-only">Open main menu</span>
                    <MenuIcon className="block h-6 w-6" aria-hidden="true"/>
                </button>
            </div>

            {/* Desktop nav area */}
            <div className="hidden md:min-w-0 md:flex-1 md:flex md:items-center md:justify-between">
                {/* Search */}
                <div className="max-w-2xl relative text-gray-400 focus-within:text-gray-500">
                    <label htmlFor="search"
                           className="sr-only">
                        Search
                    </label>
                    <div className="mt-1 relative rounded-default shadow-sm">
                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                             aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 aria-hidden="true" className="mr-3 h-4 w-4 text-alt">
                                <path fillRule="evenodd"
                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                      clipRule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" disabled className="highlight-main block w-full pl-9 max-h-9"
                               placeholder="Searching is disabled"/>
                    </div>
                </div>


                {/* Left nav area */}
                <div className="ml-10 pr-4 flex-shrink-0 flex items-center space-x-10">
                    {/* Navigation links */}
                    <nav aria-label="Global" className="flex space-x-10">
                        <a href="https://ko-fi.com/rekkisomo" className="text-sm font-medium text-primary">
                            Ko-fi
                        </a>
                        <a href="/community-guidelines" className="text-sm font-medium text-primary">
                            Guidelines
                        </a>
                    </nav>

                    {(!loggedUser && !loadingUser) &&
                        <div className="flex items-center space-x-4">
                            <a href="/id/create" className="ypsdk button-upgrade inline-flex items-center">
                                Sign Up
                            </a>

                            <a href="/login" className="ypsdk button-upgrade inline-flex items-center"
                               color="primary">
                                Login
                            </a>
                        </div>
                    }

                    {/* User actions */}
                    {loggedUser &&
                        <div className="flex items-center space-x-8">
                            {/* Notifications */}
                            <HeaderDropdownNotifications loggedUser={loggedUser}/>

                            {/* Theme switcher */}
                            <span className="inline-flex">
                            <a href="#" onClick={toggleLoggedUserColorTheme}
                               className="ypsdk button-icon -mx-1 p-1 rounded-full text-gray-400 hover:text-gray-500">
                                <span className="sr-only">Toggle dark mode</span>
                                <MoonIcon className="h-6 w-6" aria-hidden="true"/>
                            </a>
                        </span>

                            {/* User menu */}
                            <button type="button" onClick={() => setMobileMenuOpen(true)}
                                    className="relative rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                                <img className="h-8 w-8 rounded-full" src={loggedUser.avatar_url} alt=""/>
                            </button>
                        </div>
                    }

                    {/* Loading Spinner */}
                    {loadingUser &&
                        <>
                            <svg className="animate-spin -ml-1 mr-1 h-5 w-5 text-primary"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24">
                                <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path className="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </>
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
                            className="hidden sm:block sm:fixed sm:inset-0 sm:bg-gray-600 sm:bg-opacity-75"/>
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
                            className="fixed z-40 inset-0 h-full w-full bg-box sm:inset-y-0 sm:left-auto sm:right-0 sm:max-w-sm sm:w-full sm:shadow-lg"
                            aria-label="Global"
                        >
                            <div className="h-16 flex items-center justify-between px-4 sm:px-6">
                                <a href="/">
                                    <img
                                        className="block h-8 w-auto"
                                        src={yipnyap_constants.logo_url}
                                        alt="Yipnyap Logo"
                                    />
                                </a>
                                <button
                                    type="button"
                                    className="-mr-2 inline-flex items-end justify-end p-2 rounded-default text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    <span className="sr-only">Close main menu</span>
                                    <XIcon className="block h-6 w-6" aria-hidden="true"/>
                                </button>
                            </div>
                            <div className="mt-2 max-w-8xl mx-auto px-4 sm:px-6">
                                {/* Mobile Search Bar */}
                                <div className="relative md:hidden text-gray-400 focus-within:text-gray-500">
                                    <label htmlFor="search" className="sr-only">
                                        Search Yipnyap
                                    </label>
                                    <input
                                        id="search"
                                        type="search"
                                        placeholder="Search Yipnyap"
                                        className="block w-full border-gray-300 rounded-default pl-10 placeholder-gray-500 focus:border-indigo-600 focus:ring-indigo-600"
                                        style={{background: 'var(--color-header-background)'}}
                                    />
                                    <div
                                        className="absolute inset-y-0 left-0 flex items-center justify-center pl-3">
                                        <SearchIcon className="h-5 w-5" aria-hidden="true"/>
                                    </div>
                                </div>
                            </div>
                            <div className="max-w-8xl mx-auto py-3 px-2 sm:px-4">
                                {navigation.map((item) => (
                                    <Fragment key={item.name}>
                                        <a
                                            href={item.href}
                                            className="header-menu-entity py-2 px-3 text-primary"
                                        >
                                            {item.name}
                                        </a>
                                        {item.children.map((child) => (
                                            <a
                                                key={child.name}
                                                href={child.href}
                                                className="header-menu-entity py-2 pl-5 pr-3 text-base text-gray-500"
                                            >
                                                {child.name}
                                            </a>
                                        ))}
                                    </Fragment>
                                ))}
                            </div>
                            <div className="border-t border-gray-200 pt-4 pb-3">
                                <div className="max-w-8xl mx-auto px-4 flex items-center sm:px-6">
                                    <div className="flex-shrink-0">
                                        <img className="h-10 w-10 rounded-full" src={loggedUser.avatar_url}
                                             alt=""/>
                                    </div>
                                    <a href={loggedUser.link} className="ml-3 min-w-0 flex-1">
                                        <div
                                            className="text-base font-medium text-primary truncate">{loggedUser.name}</div>
                                        <div
                                            className="text-sm font-medium text-gray-500 truncate">@{loggedUser.mention_name}
                                        </div>
                                    </a>
                                    <a href={`${loggedUser.link}settings/notifications`}
                                       className="ml-auto flex-shrink-0 bg-box p-2 text-gray-400 hover:text-gray-500">
                                        <span className="sr-only">View notifications</span>
                                        <BellIcon className="h-6 w-6" aria-hidden="true"/>
                                    </a>
                                </div>
                                <div className="mt-3 max-w-8xl mx-auto px-2 space-y-1 sm:px-4">
                                    {userNavigationMobile.map((item) => (
                                        <a
                                            key={item.name}
                                            href={item.href}
                                            className="header-menu-entity py-2 px-3 text-primary"
                                        >
                                            {item.name}
                                        </a>
                                    ))}
                                </div>
                            </div>
                        </nav>
                    </Transition.Child>
                </Dialog>
            </Transition.Root>
        </header>
    );
}
