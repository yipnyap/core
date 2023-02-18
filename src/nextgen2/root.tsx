import React from "react";
import ContextProvider from "./ContextProvider";
import {PageHeadingProvider, useHeading} from "@legacy/providers/PageHeading.provider";
import {NGBody, NGContent, NGSideNav} from "./components";
import {Outlet} from "react-router-dom";
import {BellIcon, HomeIcon, UserIcon} from "@heroicons/react/24/solid";

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

    document.body.style.overflow = 'hidden';

    const navigation = [
        {name: 'Home', href: '/home/', icon: HomeIcon},
        // {name: 'Trending', href: '#', icon: FireIcon},
        // {name: 'Bookmarks', href: '#', icon: BookmarkIcon},
        {name: 'Notifications', href: '#', icon: BellIcon},
        {
            name: 'Profile',
            href: yipnyap_constants.currentUser ? `/${yipnyap_constants.currentUser.username}/` : '/id/create',
            icon: UserIcon
        },
    ];

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
