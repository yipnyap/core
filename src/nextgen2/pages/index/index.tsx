/**
 * Yipnyap's root home page.
 *
 * 🔬 Testing out a curated home page, with a few different sections.
 *    Trying to engage the user with a few different things.
 *
 * @file index.tsx
 */
import {useHeading} from "@legacy/providers/PageHeading.provider";
import React, {useEffect, useState} from "react";
import {NavLink, useLocation} from "react-router-dom";
import {NGContentNavigatorItemType} from "@nextgen2/components/NGContentNavigator/NGContentNavigator";
import {getMemberFriends, getMemberGroups} from "@legacy/router/v2/members/get";
import {BellIcon, HomeIcon, NewspaperIcon, SquaresPlusIcon, UserPlusIcon} from "@heroicons/react/24/solid";
import {useTheme} from "@legacy/providers/contexts";
import {Void} from "@nextgen2";
import SettingsTelegram from "@nextgen2/pages/settings/telegram";
import {NGCard, NGNewUserOnboarding} from "@nextgen2/components";

// @ts-ignore
import ActivityFilterableList from "@legacy/component/activity/ActivityFilterableList";
// @ts-ignore
import Loader from '@legacy/component/loader/Loader';
// @ts-ignore
import NoUserCTAActivity from "@legacy/component/onboarding/NoUserCTAActivity";

import {Cog6ToothIcon, PlusIcon} from "@heroicons/react/20/solid";
import {NGGroupCard} from "@nextgen2/components/NGGroupCard";
import Home from "@nextgen2/pages/index/home";
import Notifications from "@nextgen2/pages/index/notifications";

export function Index({...props}) {
    const [, setHeading] = useHeading();
    const [theme,] = useTheme();
    const location = useLocation();
    const [userGroups, setUserGroups] = useState<NGContentNavigatorItemType[]>([]);
    const [userFriends, setUserFriends] = useState<NGContentNavigatorItemType[]>([]);
    const [currentGroup, setCurrentGroup] = useState<string | false>();
    const [showVoid, setShowVoid] = useState<boolean>(false);
    const [readyToRender, setReadyToRender] = useState<boolean>(false);

    useEffect(() => {
        // Get current user groups
        getMemberGroups(yipnyap_constants.currentUser?.id).then((groups) => {
            const userGroupsBuild = [];
            if (!Array.isArray(groups)) return;
            for (const group of groups) {
                userGroupsBuild.push({
                    name: group.name,
                    description: group.description,
                    href: `/groups/${group.id}/`,
                    icon: group.avatar,
                    current: location.pathname === `/groups/${group.id}/`,
                });
            }

            // Check if any of the groups are the current group
            if (location.pathname.startsWith('/groups/')) {
                const currentGroup = parseInt(location.pathname.split('/')[2]);
                if (currentGroup) {
                    const group = groups.find((group: { id: number; }) => group.id === currentGroup);
                    if (group) {
                        setCurrentGroup(group.id);
                        setShowVoid(false);
                    } else {
                        setCurrentGroup(false);
                        setShowVoid(true);
                    }
                }
            } else if (location.pathname === '/feed/') {
                setCurrentGroup(false);
                setShowVoid(false);
            }

            setUserGroups(userGroupsBuild);
            setReadyToRender(true);
        })

        // Get current user friends
        getMemberFriends(yipnyap_constants.currentUser?.id).then((friends) => {
            const userFriendsBuild = [];
            if (!Array.isArray(friends)) return;
            for (const friend of friends) {
                userFriendsBuild.push({
                    name: friend.display_name,
                    description: `@${friend.username}`,
                    href: `/${friend.username}/`,
                    icon: friend.avatar,
                    current: location.pathname === `/${friend.username}/`,
                });
            }
            setUserFriends(userFriendsBuild);
        })

        if (!yipnyap_constants.currentUser?.display_name) {
            setReadyToRender(true);
        }
    }, [location.pathname])

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
            slimContentNavigator: location.pathname === `/`,
            navigator: {
                heading: `Hey, ${yipnyap_constants.currentUser?.display_name || 'Stranger'}!`,
                subNavigation: [
                    {
                        name: 'Home',
                        description: '',
                        href: `/`,
                        icon: HomeIcon,
                        current: location.pathname === `/`
                    },
                    {
                        name: 'Your Feed',
                        description: '',
                        href: `/feed/`,
                        icon: NewspaperIcon,
                        current: location.pathname === `/feed/`
                    },
                    {
                        name: 'Notifications',
                        description: '',
                        href: `/notifications/`,
                        icon: BellIcon,
                        current: location.pathname === `/notifications/`
                    },
                    ...(yipnyap_constants.currentUser ? [
                        {
                            name: 'Join a group',
                            description: 'Groups you\'re a member of and your friends will appear here!',
                            href: `/groups/`,
                            target: '_top',
                            icon: SquaresPlusIcon,
                        },
                        {
                            name: 'Search for friends',
                            description: 'Your friends\' profiles will be easily accessible from here.',
                            href: `/members/`,
                            target: '_top',
                            icon: UserPlusIcon,
                        },
                    ] : []),
                    ...userGroups ?? [],
                    ...userFriends ?? [],
                ]
            }
        })
    }, [location.pathname, userGroups, userFriends]);

    return (
        <>
            {location.pathname === '/' && (<Home theme={theme}/>)}
            {location.pathname === '/notifications/' && (<Notifications/>)}
            {location.pathname === '/feed/' || location.pathname.startsWith('/groups/') && (
                <div className="flex flex-col mx-auto px-4">
                    {showVoid ? <Void/> : (
                        <>
                            {
                                (yipnyap_constants.currentUser && !yipnyap_constants.currentUser?.tgid) && (
                                    <div className="flex flex-col justify-center m-auto py-8 max-w-4xl">
                                        <SettingsTelegram onlyShowOnboarding={true}/>
                                    </div>
                                )
                            }
                            <div
                                id="onboarding-create_post"
                                className="flex flex-row justify-center space-x-4 mx-auto py-8 max-w-4xl"
                            >
                                {
                                    readyToRender ? (
                                        <>
                                            {currentGroup !== false ? (
                                                <ActivityFilterableList order="DESC"
                                                                        groupID={currentGroup}
                                                                        perPage={5}
                                                                        element="NGContent"
                                                                        className="w-full"/>
                                            ) : (
                                                <ActivityFilterableList order="DESC"
                                                                        perPage={5}
                                                                        element="NGContent"
                                                                        className="w-full"/>
                                            )}
                                        </>
                                    ) : (
                                        <Loader/>
                                    )
                                }

                                {readyToRender && (
                                    <div
                                        className="w-72 hidden 2xl:block space-y-4 overflow-y-auto overflow-x-visible">
                                        {yipnyap_constants.currentUser?.username && (
                                            <NGCard
                                                title={
                                                    <p className="text-sm leading-5 text-neutral-500">
                                                        <b className="text-secondary">
                                                            {yipnyap_constants.currentUser?.online_count === 1
                                                                ? 'Only you'
                                                                : yipnyap_constants.currentUser?.online_count}
                                                        </b>
                                                        {yipnyap_constants.currentUser?.online_count > 1 ? ' people' : ''} are
                                                        online this minute.
                                                    </p>}
                                                wellBody={true}
                                            >
                                                {yipnyap_constants.currentUser?.online_count < 3 && (
                                                    <p className="text-sm leading-5 text-neutral-500">
                                                        Yipnyap is better with others! Tell 'em to join or login.
                                                    </p>
                                                )}
                                            </NGCard>
                                        )}

                                        <NGCard
                                            title={
                                                <h3 className="text-primary font-extrabold">
                                                    Help us make Yipnyap more comfy
                                                </h3>}
                                            wellBody={true}>
                                            <p className="text-sm leading-5 text-neutral-500">
                                                Help us make a chill, joyful, and welcoming experience by joining in
                                                on the conversation!
                                            </p>
                                            <div className="mt-3 text-sm leading-5">
                                                <a
                                                    className="font-medium text-primary hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
                                                    href="https://discord.gg/wrCGpAB"
                                                    target="_blank"
                                                >
                                                    Join the Discord &rarr;
                                                </a>
                                            </div>
                                        </NGCard>
                                    </div>
                                )}
                            </div>
                        </>
                    )}
                </div>
            )}
        </>
    );
}