import {getMemberFriends} from '@legacy/router/v2/members/get';
import React, {useEffect, useState} from 'react';
import ContextProvider from './ContextProvider';
import {PageHeadingProvider, useHeading} from '@nextgen2/providers/PageHeading.provider';
import {NGBody, NGContent, NGSideNav} from './components';
import {Outlet} from 'react-router-dom';
import {BellIcon, HomeIcon, UserIcon} from '@heroicons/react/24/solid';
import {ThemeContextProvider, useTheme} from '@nextgen2/providers/Theme.provider';
import NotificationContextProvider, {
    NotificationContainer, useNotification,
} from '@nextgen2/providers/Notification.provider';

export default function Root() {
    return (
        <ContextProvider>
            <PageHeadingProvider>
                <NotificationContainer/>
                <RootWithinProvider/>
            </PageHeadingProvider>
        </ContextProvider>
    )
}

function RootWithinProvider() {
    const [heading] = useHeading();
    const [theme] = useTheme();
    const [, addNotification, removeNotification] = useNotification();
    const [friends, setFriends] = useState<any>(null);
    const [ready, setReady] = useState(false);

    document.body.style.overflow = 'hidden';

    const navigation = [{
        name: 'Home',
        href: '/',
        icon: HomeIcon,
    }, // {name: 'Trending', href: '#', icon: FireIcon},
        // {name: 'Bookmarks', href: '#', icon: BookmarkIcon},
        {
            name: 'Notifications',
            href: '/notifications/',
            icon: BellIcon,
        }, {
            name: 'Profile',
            href: yipnyap_constants.currentUser ? `/${yipnyap_constants.currentUser.username}/` : '/id/create',
            icon: UserIcon,
        }];

    // run this useEffect only once
    useEffect(() => {
        const allowConnection = sessionStorage.getItem('alreadyOnWS') !== 'true';
        window.onbeforeunload = function () {
            sessionStorage.removeItem('alreadyOnWS');
        };
        // @ts-ignore
        if (module.hot && allowConnection) {
            sessionStorage.setItem('alreadyOnWS', 'true');
            // Connect to webpack-dev-server socket
            let connection = new WebSocket('ws://localhost:9000/ws');

            // Listen for messages
            connection.onmessage = (e) => {
                const data = JSON.parse(e.data);
                console.log('[🔥 Hot] Message: ', data);

                switch (data.type) {
                    case 'invalid':
                        // Invalid gets sent on rebuild
                        addNotification({
                            id: 'hot-reloading',
                            title: 'Wait',
                            message: 'Rebuild in progress',
                            type: 'warning',
                            persistent: true,
                        });
                        break;
                    case 'hash':
                        removeNotification('hot-reloading');
                        addNotification({
                            title: 'HMR Done',
                            message: 'Rebuild complete',
                            type: 'success',
                        });
                        break;
                    case 'warnings':
                        addNotification({
                            title: 'Rebuilt with warnings',
                            message: `${data.data.length} warnings`,
                            type: 'warning',
                        });
                        break;
                    default:
                        break;
                }
            }

            // On connect, submit to notification
            connection.onopen = () => {
                console.log('[🔥 Hot] Connected');
                addNotification({
                    title: 'Running in development mode',
                    message: 'Connected to hot reloading server',
                    type: 'success',
                });
            }
        }

        // Even though its super early, we should already be able to access the current user.
        // Get the user's friends and store them in the state
        if (yipnyap_constants.currentUser) {
            getMemberFriends(yipnyap_constants.currentUser.id).then((data) => {
                setFriends(data);
                setReady(true);
            })
        }

    }, []);

    useEffect(() => {
        console.log('[🌇 Theme] Change: ', theme)
        const systemIsDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        console.log('[🌇 Theme] System dark: ', systemIsDark)
        if (theme.variant === 'dark' || (
            theme.variant === 'system' && systemIsDark
        )) {
            if (!document.body.classList.contains('dark')) document.body.classList.add('dark');
        } else {
            if (document.body.classList.contains('dark')) document.body.classList.remove('dark');
        }
    }, [theme]);

    return (
        <div className="h-full flex overflow-none">
            <NGSideNav items={navigation}
                       slimContentNavigator={heading?.slimContentNavigator}
                       showContentNavigator={true}
                       contentNavigatorItems={heading?.navigator?.subNavigation}
                       contentNavigatorHeading={heading?.navigator?.heading}>
                <NGContent srHeading={'Unknown'} heading={heading || {heading: null}}>
                    <Outlet/>
                </NGContent>

                <div
                    className="hidden xl:flex flex-col sticky w-80 top-0 p-8 space-y-16 col-span-2 bg-sidebar border-0 border-l border-solid border-default dark:bg-sidebar-dark">
                    {/* Top header text */}
                    <h4 className="font-regular">
                        {!friends ? 'Yipnyap is communicating...' : 'Happening Now'}
                    </h4>
                    <div className="flex flex-col space-y-8 bg-box-solid rounded-default p-8">
                        <h4 className="font-regular">
                            Active Friends
                        </h4>
                        {/* Friends list */}
                        {!friends && (
                            <div className="flex flex-col space-y-4">
                                <div className="flex space-x-4">
                                    <div className="w-10 h-10 rounded-full bg-gray-300 animate-pulse"/>
                                    <div className="flex-1 space-y-4 py-1">
                                        <div className="h-4 bg-gray-300 rounded w-3/4 animate-pulse"/>
                                        <div className="space-y-2">
                                            <div className="h-4 bg-gray-300 rounded w-5/6 animate-pulse"/>
                                            <div className="h-4 bg-gray-300 rounded w-4/6 animate-pulse"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="flex space-x-4">
                                    <div className="w-10 h-10 rounded-full bg-gray-300 animate-pulse"/>
                                    <div className="flex-1 space-y-4 py-1">
                                        <div className="h-4 bg-gray-300 rounded w-3/4 animate-pulse"/>
                                        <div className="space-y-2">
                                            <div className="h-4 bg-gray-300 rounded w-5/6 animate-pulse"/>
                                            <div className="h-4 bg-gray-300 rounded w-4/6 animate-pulse"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="flex space-x-4">
                                    <div className="w-10 h-10 rounded-full bg-gray-300 animate-pulse"/>
                                    <div className="flex-1 space-y-4 py-1">
                                        <div className="h-4 bg-gray-300 rounded w-3/4 animate-pulse"/>
                                        <div className="space-y-2">
                                            <div className="h-4 bg-gray-300 rounded w-5/6 animate-pulse"/>
                                            <div className="h-4 bg-gray-300 rounded w-4/6 animate-pulse"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}
                        {friends && friends.map((friend: {
                            avatar: string; display_name: string; username: string;
                        }) => (
                            <div className="flex flex-row items-center space-x-2">
                                <div className="w-10 h-10 rounded-full bg-box" style={{
                                    background: `url(${friend.avatar}) no-repeat center center/cover`,
                                }}></div>
                                <div className="flex flex-col">
                                    <p>{friend.display_name}</p>
                                    <p className="text-sm text-alt-2">{friend.username}</p>
                                </div>
                            </div>
                        ))}

                    </div>
                </div>
            </NGSideNav>
        </div>
    );
}
