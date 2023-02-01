import React, {useEffect, useState} from 'react';
import {useLocation} from "react-router-dom";
import {
    HomeIcon,
} from "@heroicons/react/24/outline";
import {Void} from '../..';
import {useHeading} from "../../../../providers/PageHeading.provider";
import {getMemberFriends, getMemberGroups} from "../../../../router/v2/members/get";
import {NGContentNavigatorItemType} from "../../components/NGContentNavigator/NGContentNavigator";
import {NGCard} from "../../components";
// @ts-ignore
import ActivityFilterableList from "../../../legacy/activity/ActivityFilterableList";
// @ts-ignore
import Loader from '../../../legacy/loader/Loader';
// @ts-ignore
import NoUserCTAActivity from "../../../legacy/onboarding/NoUserCTAActivity";
import SettingsTelegram from "../profile/pages/settings/telegram";

export default function Activity() {
    const location = useLocation();
    const [, setHeading] = useHeading();
    const [userGroups, setUserGroups] = useState<NGContentNavigatorItemType[]>([]);
    const [userFriends, setUserFriends] = useState<NGContentNavigatorItemType[]>([]);
    const [currentGroup, setCurrentGroup] = useState<string | false>();
    const [showVoid, setShowVoid] = useState<boolean>(false);
    const [readyToRender, setReadyToRender] = useState<boolean>(false);

    useEffect(() => {
        // Get current user groups
        getMemberGroups(yipnyap_constants.currentUser.id).then((groups) => {
            const userGroupsBuild = [];
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
        })

        // Get current user friends
        getMemberFriends(yipnyap_constants.currentUser.id).then((friends) => {
            const userFriendsBuild = [];
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
            setReadyToRender(true);
        })

        if (!yipnyap_constants.currentUser?.display_name) {
            setReadyToRender(true);
        }
    }, [location.pathname])

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
            navigator: {
                heading: `Hey, ${yipnyap_constants.currentUser.display_name || 'Stranger'}!`,
                subNavigation: [
                    {
                        name: 'Home',
                        description: '',
                        href: `/home/`,
                        icon: HomeIcon,
                        current: location.pathname === `/home/`
                    },
                    ...userGroups ?? [],
                    ...userFriends ?? [],
                ]
            }
        })
    }, [location.pathname, userGroups, userFriends])

    return (
        <div className="p-4 md:p-0">
            {showVoid ? <Void/> : (
                <>
                    {!yipnyap_constants.currentUser?.display_name && <NoUserCTAActivity/>}
                    {
                        (yipnyap_constants.currentUser?.display_name && !yipnyap_constants.currentUser?.tgid) && (
                            <div className="flex flex-col justify-center m-auto py-8 max-w-4xl">
                                <SettingsTelegram onlyShowOnboarding={true}/>
                            </div>
                        )
                    }
                    <div className="flex flex-row justify-center space-x-4 m-auto py-8 max-w-4xl">
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

                        <div className="w-72 hidden 2xl:block space-y-4 overflow-y-auto overflow-x-visible">
                            {yipnyap_constants.currentUser?.username && (
                                <NGCard
                                    title={
                                        <p className="text-sm leading-5 text-gray-500">
                                            <b className="text-secondary">
                                                {yipnyap_constants.currentUser.online_count === 1
                                                    ? 'Only you'
                                                    : yipnyap_constants.currentUser.online_count}
                                            </b>
                                            {yipnyap_constants.currentUser.online_count > 1 ? ' people' : ''} are
                                            online.
                                        </p>}
                                    wellBody={true}
                                >
                                    {yipnyap_constants.currentUser.online_count < 3 && (
                                        <p className="text-sm leading-5 text-gray-500">
                                            Yipnyap is better with friends! Tell 'em to join or login.
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
                                <p className="text-sm leading-5 text-gray-500">
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
                    </div>
                </>
            )}
        </div>
    )
}
