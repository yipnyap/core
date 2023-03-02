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
import {HomeIcon, NewspaperIcon, SquaresPlusIcon, UserPlusIcon} from "@heroicons/react/24/solid";
import {useTheme} from "@legacy/providers/contexts";
import {Void} from "@nextgen2";
import SettingsTelegram from "@nextgen2/pages/profile/pages/settings/telegram";
import {NGCard, NGNewUserOnboarding} from "@nextgen2/components";

// @ts-ignore
import ActivityFilterableList from "@legacy/component/activity/ActivityFilterableList";
// @ts-ignore
import Loader from '@legacy/component/loader/Loader';
// @ts-ignore
import NoUserCTAActivity from "@legacy/component/onboarding/NoUserCTAActivity";

import {Cog6ToothIcon, PlusIcon} from "@heroicons/react/20/solid";

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
            } else if (location.pathname === '/home/') {
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
                        href: `/home/`,
                        icon: NewspaperIcon,
                        current: location.pathname === `/home/`
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
            {
                location.pathname === '/'
                    ? (<div className="flex justify-center m-auto lg:grid grid-cols-10 h-full">
                        <div className="flex flex-col col-span-8 px-20 py-10 space-y-12">
                            <div className="space-y-6">
                                <div
                                    className="px-20 py-10 rounded-xl highlight-white/5"
                                    style={{
                                        backgroundImage: `linear-gradient(rgba(0, 0, 0, ${theme.variant === 'dark' ? '0.3' : '0'}), rgba(0, 0, 0, 0.3)), url(https://cdn.dribbble.com/users/966188/screenshots/15283925/media/8b8663dc8f6e6a2fd80a201aec1ffbb6.jpg)`
                                    }}
                                >
                                    <div className="flex flex-col md:w-1/2 space-y-4">
                                        <h1 className="text-3xl text-white">Welcome to Yipnyap!</h1>
                                        <p className="text-lg text-white font-light">
                                            Yipnyap is a place for furries to connect with each other. It's a social network
                                            that's built for furries, by furries. We're still in development, but we're
                                            working hard to make Yipnyap the best place for furries to connect with each
                                            other!
                                        </p>
                                    </div>
                                </div>

                                {yipnyap_constants.currentUser && (
                                    <>
                                        <div className="p-8 bg-box rounded-xl highlight-white/5">
                                            <div className="flex flex-col md:flex-row items-center justify-center">
                                                <div className="flex flex-col flex-grow md:w-1/2 space-y-2">
                                                    <h4 className="text-lg">Add your friends</h4>
                                                    <p className="text-alt-2">
                                                        Add your friends to Yipnyap! The more people we have, the more fun
                                                        we
                                                        can have!
                                                    </p>
                                                </div>

                                                {/* Button CTA */}
                                                <a href="/members/"
                                                   className="w-auto inline-flex p-4 highlight-white/5 rounded-default shadow-sm bg-default text-sm font-medium hover:bg-neutral-50 dark:hover:bg-neutral-700">
                                                    <UserPlusIcon
                                                        className="-ml-1 mr-2 h-5 w-5 text-neutral-400 dark:text-white"/>
                                                    <span>Add a friend</span>
                                                </a>
                                            </div>
                                        </div>

                                        {(!yipnyap_constants.currentUser?.tgid) && (
                                            <div className="p-8 bg-box rounded-xl highlight-white/5">
                                                <div className="flex flex-col md:flex-row items-center justify-center">
                                                    <div className="flex flex-col flex-grow md:w-1/2 space-y-2">
                                                        <h4 className="text-lg">Link your Telegram</h4>
                                                        <p className="text-alt-2">
                                                            Telegram is used to ensure that you're a real person. It's also
                                                            used to
                                                            send you 2FA codes, notifications, and more!
                                                        </p>
                                                    </div>

                                                    {/* Button CTA */}
                                                    <NavLink to="/settings/telegram">
                                                        <button
                                                            className="w-auto inline-flex p-4 highlight-white/5 rounded-default shadow-sm bg-default text-sm font-medium hover:bg-neutral-50 dark:hover:bg-neutral-700">
                                                            <Cog6ToothIcon
                                                                className="-ml-1 mr-2 h-5 w-5 text-neutral-400 dark:text-white"/>
                                                            <span>Link Telegram</span>
                                                        </button>
                                                    </NavLink>
                                                </div>
                                            </div>
                                        )}
                                    </>
                                )}
                            </div>

                            {(yipnyap_constants.currentUser && !yipnyap_constants.currentUser?.dipswitch?.hide_onboarding) && (
                                <NGNewUserOnboarding/>
                            )}

                            {/* Grid of recommended groups */}
                            <div className="flex flex-col">
                                <h2 className="text-2xl">Recommended Groups</h2>
                                <div className="mt-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
                                    <div className="flex flex-col rounded-default bg-box highlight-white/5">
                                        {/* Banner */}
                                        <div className="w-full h-24 rounded-default bg-box"></div>

                                        <div className="space-y-4 justify-between items-center px-4 py-2">
                                            <div className="flex flex-row items-center space-x-2">
                                                <div className="w-8 h-8 rounded-full bg-box"></div>
                                                <div className="flex flex-col">
                                                    <h3 className="text-lg">Group Name</h3>
                                                    <p className="text-sm text-neutral-500">Group Description</p>
                                                </div>
                                            </div>

                                            <div className="flex flex-row">
                                                <div className="flex flex-row flex-grow items-center space-x-2">
                                                    <div className="flex flex-col">
                                                        <p className="text-sm text-neutral-500">Members</p>
                                                        <p className="text-sm">1,000</p>
                                                    </div>
                                                    <div className="flex flex-col">
                                                        <p className="text-sm text-neutral-500">Posts</p>
                                                        <p className="text-sm">1,000</p>
                                                    </div>
                                                </div>
                                                {/* Join button icon */}
                                                <button
                                                    className="flex flex-row items-center justify-center w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-700">
                                                    <PlusIcon className="w-4 h-4 text-white"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            className="hidden lg:flex col-span-2 bg-sidebar border-0 border-l border-solid border-default dark:bg-sidebar-dark"></div>
                    </div>)
                    : (
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
                    )
            }
        </>
    )
}