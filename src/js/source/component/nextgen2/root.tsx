import ContextProvider from "./ContextProvider";
import {PageHeadingProvider, useHeading} from "../../providers/PageHeading.provider";
import {useUser} from "../../providers/contexts";
import React, {useEffect} from "react";
import {NGBody, NGContent, NGSideNav} from "../../nextgen";
import {Outlet, useLocation} from "react-router-dom";
import {HomeIcon, UserIcon} from "@heroicons/react/24/outline";

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
    const [user, setUser] = useUser();
    const [heading] = useHeading();
    const location = useLocation();

    useEffect(() => {
        const cachedUserString = localStorage.getItem('cachedUser');
        const cachedToken = localStorage.getItem('token');
        const cachedUser = cachedUserString && (JSON.parse(cachedUserString));
        if (cachedUser && !user.loggedIn) {
            setUser({
                // @ts-ignore
                ...cachedUser,
                token: cachedToken
            })
        }
    })

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
