/**
 * Groups page
 *
 * @author: Rekkisomo
 * @version: ui2
 */

import React, {useEffect, useState} from 'react';
import {useLocation} from "react-router-dom";
import {NGBody, NGSkeleton} from "@nextgen2/components";
import {MegaphoneIcon, UserGroupIcon, HomeIcon} from "@heroicons/react/24/solid";
import {useHeading} from "@nextgen2/providers/PageHeading.provider";
// @ts-ignore
import ActivityFilterableList from "@legacy/component/activity/ActivityFilterableList";
import {getMemberGroups} from "@legacy/router/v2/members/get";

export default function GroupsIndex() {
    const location = useLocation();
    const [, setHeading] = useHeading();
    const [groupID, setGroupID] = useState(location.pathname.split('/')[2]);
    const [current, setCurrent] = useState(location.pathname.split('/')[3]);
    const [ready, setReady] = useState(false);

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
            navigator: {
                heading: `Some Group Name`,
                subNavigation: [
                    {
                        name: 'Group Home',
                        description: '',
                        href: `/groups/${groupID}/`,
                        icon: HomeIcon,
                        current: location.pathname === `/groups/${groupID}/`
                    },
                    {
                        name: 'Members',
                        description: '',
                        href: `/groups/${groupID}/members`,
                        icon: UserGroupIcon,
                        current: location.pathname === `/groups/${groupID}/members`
                    },
                    {
                        name: 'Announcements',
                        description: '',
                        href: `/groups/${groupID}/announcements`,
                        icon: MegaphoneIcon,
                        current: location.pathname === `/groups/${groupID}/announcements`
                    }
                ]
            }
        })

        getMemberGroups(yipnyap_constants.currentUser?.id).then((groups) => {
            setReady(true);
        });

        setCurrent(location.pathname.split('/')[3]);
    }, [location.pathname])

    return (
        <NGBody>
            {/* TODO: Move this as it's own component */}
            <div className="relative z-10 pb-8 rounded-default bg-box">
                <img className="rounded-default aspect-banner object-cover"
                     src={`${yipnyap_constants.yipnyap_url}/img/illustrations/home/fox-in-snowy-oasis.webp`}
                     alt="Profile cover"/>
                <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                        <div className="flex">
                            <img
                                className="bg-default h-24 w-24 rounded-default ring-4 ring-white dark:ring-neutral-800 sm:h-32 sm:w-32"
                                src={`${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`} alt=""/>
                        </div>
                        <div
                            className="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                            <div className="sm:hidden md:block mt-6 min-w-0 flex-1">
                                <h1 className="text-2xl font-bold text-default truncate">
                                    Some Group Name
                                </h1>
                                {/* Small @username */}
                                <div className="flex items-center">
                                    <p className="text-sm font-medium text-alt-2 truncate">
                                        @some-group-handle
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="hidden sm:block md:hidden mt-6 min-w-0 flex-1">
                        <h1 className="text-2xl font-bold text-default truncate">Some Group Name</h1>
                    </div>
                    <div className="block mt-6 min-w-0 flex-1 text-default">
                        {/* Bio */}
                        <p className="text-sm whitespace-pre-line">
                            weee weoooo oweoweoweowoewoew
                        </p>

                        <div className="mt-2 flex flex-col text-sm text-alt-2">
                            <div className="flex">
                                <UserGroupIcon className="flex-shrink-0 mr-1.5 h-5 w-5" aria-hidden="true"/>
                                <span>
                                    9,999,999 cummies
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!ready ? (
                <NGSkeleton/>
            ) : (
                <>
                    {current === '' && (
                        <ActivityFilterableList
                            order="DESC"
                            groupID
                            perPage={5}
                            element="NGContent"
                            className="w-full"/>
                    )}
                </>
            )}

        </NGBody>
    )
}


