import {getMemberFriends} from '@legacy/router/v2/members/get';
import React, {useEffect, useState} from 'react';
import ContextProvider from './ContextProvider';
import {PageHeadingProvider, useHeading} from '@nextgen2/providers/PageHeading.provider';
import {NGContent, NGSideNav} from './components';
import {Link, Outlet} from 'react-router-dom';
import {BellIcon, HeartIcon, HomeIcon, UserIcon} from '@heroicons/react/24/solid';
import {useTheme} from '@nextgen2/providers/Theme.provider';
import {NotificationContainer} from '@nextgen2/providers/Notification.provider';
import {CssVarsProvider, StyledEngineProvider} from '@mui/joy';
import theme from './theme';
// @ts-ignore
import { Flags, FlagsProvider } from 'react-feature-flags';

export default function Root() {
    return (
        <FlagsProvider value={[
            { name: 'JoyUINavigation', isActive: localStorage.getItem('JoyUINavigation') === 'true' }
        ]}>
            <StyledEngineProvider injectFirst>
                <CssVarsProvider defaultMode="system" theme={theme}>
                    <ContextProvider>
                        <PageHeadingProvider>
                            <NotificationContainer/>
                            <RootWithinProvider/>
                        </PageHeadingProvider>
                    </ContextProvider>
                </CssVarsProvider>
            </StyledEngineProvider>
        </FlagsProvider>
    )
}

function RootWithinProvider() {
    const [heading] = useHeading();
    const [theme] = useTheme();
    const [friends, setFriends] = useState<any>(null);
    const [ready, setReady] = useState(false);

    const [themeBackground, setThemeBackground] = useState<string | null>();

    document.body.style.overflow = 'hidden';

    const navigation = [{
        name: 'Home',
        href: '/',
        icon: HomeIcon,
    }, ...(
        yipnyap_constants.currentUser ? [{
            name: 'Notifications',
            href: '/notifications/',
            icon: BellIcon,
        }] : []
    ), {
        name: 'Profile',
        tags: 'login register logout account settings profile user, identity',
        href: yipnyap_constants.currentUser ? `/${yipnyap_constants.currentUser.username}/` : '/id/create',
        icon: UserIcon,
    }, {
        name: 'Donate',
        href: '/fund/',
        icon: HeartIcon,
    }];

    // run this useEffect only once
    useEffect(() => {
        // Even though its super early, we should already be able to access the current user.
        // Get the user's friends and store them in the state
        if (yipnyap_constants.currentUser) {
            getMemberFriends(yipnyap_constants.currentUser.id).then((data) => {
                setFriends(data);
                setReady(true);
            })
        } else {
            setReady(true);
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

        setThemeBackground(theme.background)
    }, [theme]);

    return (
        <div className="h-full flex overflow-none">
            <div className="absolute w-full h-full -z-10" style={{
                background: themeBackground || 'var(--bg-body)',
            }}></div>
            <NGSideNav items={navigation}
                       slimContentNavigator={heading?.slimContentNavigator}
                       showContentNavigator={true}
                       contentNavigatorItems={heading?.navigator?.subNavigation}
                       contentNavigatorHeading={heading?.navigator?.heading}>
                <NGContent srHeading={'Unknown'} heading={heading || {heading: null}}>
                    <Outlet/>
                </NGContent>

                <Flags authorizedFlags={['JoyUINavigation']}
                       renderOff={() => (
                           <div
                               className="hidden 2xl:flex flex-col sticky w-80 top-0 p-8 space-y-16 col-span-2 bg-sidebar-default/75 backdrop-blur-lg border-0 border-l border-solid border-default dark:bg-sidebar-dark/75">
                               {/* Top header text */}
                               <h4 className="font-regular">
                                   {!ready && 'Yipnyap is communicating...'}
                                   {ready && yipnyap_constants.currentUser && 'Happening Now'}
                                   {ready && !yipnyap_constants.currentUser && (
                                       <>
                                           <span className="font-bold">Yipnyap</span> is a social network for
                                           furries, by furries (cliche, I know). It's a place to share your
                                           thoughts, meet new people, and have fun! <br/><br/>
                                           <span className="font-bold">Yipnyap</span> is still in development,
                                           so expect bugs and missing features. If you find any, please report
                                           them on the <a className="text-blue-500" href="https://work.yipnyap.me/"
                                                          target="_blank">
                                           Yipnyap Workboard</a>!
                                           <br/><br/>
                                           When you're logged in, you'll be able to see what your friends are
                                           up to here, and you'll be able to get your own notifications. If you
                                           don't have an account, you can create one <Link className="text-blue-500"
                                                                                           to="/id/create">here</Link>.
                                       </>
                                   )}
                               </h4>
                               {yipnyap_constants.currentUser && (
                                   <div className="flex flex-col space-y-8 bg-box-alt rounded-default p-8">
                                       <h4 className="font-regular">
                                           Active Friends
                                       </h4>
                                       {/* Friends list */}
                                       {!ready && (
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
                                           online: boolean; avatar: string; display_name: string; username: string;
                                       }, friendIdx: number) => friend.online ? (
                                           <div key={friendIdx} className="flex flex-row items-center space-x-2">
                                               <div className="w-10 h-10 rounded-full bg-box" style={{
                                                   background: `url(${friend.avatar}) no-repeat center center/cover`,
                                               }}></div>
                                               <div className="flex flex-col">
                                                   <p>{friend.display_name}</p>
                                                   <p className="text-sm text-alt-2">{friend.username}</p>
                                               </div>
                                           </div>
                                       ) : friendIdx === friends.length - 1 && (
                                           <p className="text-sm text-alt-2">No friends online</p>
                                       ))}
                                   </div>
                               )}
                           </div>
                       )}
                />
            </NGSideNav>
        </div>
    );
}
