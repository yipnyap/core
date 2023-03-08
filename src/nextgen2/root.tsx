import React, {useEffect} from "react";
import ContextProvider from "./ContextProvider";
import {PageHeadingProvider, useHeading} from "@nextgen2/providers/PageHeading.provider";
import {NGBody, NGContent, NGSideNav} from "./components";
import {Outlet} from "react-router-dom";
import {BellIcon, HomeIcon, UserIcon} from "@heroicons/react/24/solid";
import {useTheme} from "@nextgen2/providers/Theme.provider";

export default function Root() {
    return (
        <ContextProvider>
            <PageHeadingProvider>
                <RootWithinProvider />
            </PageHeadingProvider>
        </ContextProvider>
    )
}

function RootWithinProvider() {
    const [heading] = useHeading();
    const [theme] = useTheme();

    document.body.style.overflow = 'hidden';

    const navigation = [
        {name: 'Home', href: '/', icon: HomeIcon},
        // {name: 'Trending', href: '#', icon: FireIcon},
        // {name: 'Bookmarks', href: '#', icon: BookmarkIcon},
        {name: 'Notifications', href: '/notifications/', icon: BellIcon},
        {
            name: 'Profile',
            href: yipnyap_constants.currentUser ? `/${yipnyap_constants.currentUser.username}/` : '/id/create',
            icon: UserIcon
        },
    ];

    useEffect(() => {
        console.log('[🌇 Theme] Change: ', theme)
        const systemIsDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        console.log('[🌇 Theme] System dark: ', systemIsDark)
        if (theme.variant === 'dark' || (theme.variant === 'system' && systemIsDark)) {
            if (!document.body.classList.contains('dark')) document.body.classList.add('dark');
        } else {
            if (document.body.classList.contains('dark')) document.body.classList.remove('dark');
        }
    }, [theme]);

    return (
        <NGBody>
            <NGSideNav items={navigation}
                       slimContentNavigator={heading?.slimContentNavigator}
                       showContentNavigator={true}
                       contentNavigatorItems={heading?.navigator?.subNavigation}
                       contentNavigatorHeading={heading?.navigator?.heading}>
                <NGContent srHeading={'Unknown'} heading={heading || {heading: null}}>
                    <Outlet/>
                </NGContent>
            </NGSideNav>
        </NGBody>
    );
}
