import ContextProvider from "./ContextProvider";
import {PageHeadingProvider, useHeading} from "@legacy/providers/PageHeading.provider";
import React from "react";
import {NGBody, NGContent, NGSideNav} from "./components";
import {Outlet} from "react-router-dom";
import {HomeIcon, UserIcon} from "@heroicons/react/24/solid";

const navigation = [
    {name: 'Home', href: '/feed', icon: HomeIcon},
    // {name: 'Trending', href: '#', icon: FireIcon},
    // {name: 'Bookmarks', href: '#', icon: BookmarkIcon},
    // {name: 'Messages', href: '#', icon: InboxIcon},
    {name: 'Profile', href: '/@me', icon: UserIcon},
]

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

    return (
        <NGBody>
            <NGSideNav items={null}
                       logoURL={`${yipnyap_constants.yipnyap_url}/img/yipnyap-logo.png`}
                       slimContentNavigator={heading?.slimContentNavigator}
                       showContentNavigator={true}
                       contentNavigatorItems={heading?.navigator?.subNavigation}
                       contentNavigatorHeading={heading?.navigator?.heading}>
                <NGContent srHeading={'Unknown'} heading={heading || { heading: null }}>
                    <Outlet />
                </NGContent>
            </NGSideNav>
        </NGBody>
    );
}
