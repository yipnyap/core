import React, {useEffect, useState} from 'react';
import ContextProvider from './ContextProvider';
import {PageHeadingProvider, useHeading} from '@nextgen2/providers/PageHeading.provider';
import {NGContent, NGSideNav} from './components';
import {Outlet} from 'react-router-dom';
import {BellIcon, HeartIcon, HomeIcon, UserIcon} from '@heroicons/react/24/solid';
import {useTheme} from '@nextgen2/providers/Theme.provider';
import {NotificationContainer} from '@nextgen2/providers/Notification.provider';
import {CssVarsProvider, StyledEngineProvider} from '@mui/joy';
import theme from './theme';
// @ts-ignore
import { Flags, FlagsProvider } from 'react-feature-flags';
export default function Root() {
    // If `NextgenFeed` is undefined, it will be set to `true`
    if (localStorage.getItem('NextgenFeed') === null) localStorage.setItem('NextgenFeed', 'true');

    return (
        <FlagsProvider value={[
            { name: 'JoyUINavigation', isActive: localStorage.getItem('JoyUINavigation') === 'true' },
            { name: 'NextgenFeed', isActive: localStorage.getItem('NextgenFeed') === 'true' },
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
            </NGSideNav>
        </div>
    );
}
