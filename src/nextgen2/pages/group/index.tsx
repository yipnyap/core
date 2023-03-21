/**
 * Groups page
 *
 * @author: Rekkisomo
 * @version: ui2
 */

import {HomeIcon, MegaphoneIcon, ShieldCheckIcon, UserGroupIcon} from '@heroicons/react/24/solid';
import {ArrowUpRightIcon, InformationCircleIcon, UserPlusIcon} from '@heroicons/react/20/solid';
// @ts-ignore
import ActivityFilterableList from '@legacy/component/activity/ActivityFilterableList';
import {getMemberGroups} from '@legacy/router/v2/members/get';
import {NGBody, NGButton, NGSkeleton, NGTable} from '@nextgen2/components';
import {useNotification} from '@nextgen2/providers/Notification.provider';
import {useHeading} from '@nextgen2/providers/PageHeading.provider';
import moment from 'moment';
import React, {useEffect, useState} from 'react';
import {Link, useLocation} from 'react-router-dom';

export default function GroupsIndex() {
    const location = useLocation();
    const [, setHeading] = useHeading();
    const [, addNotification] = useNotification();
    const [group, setGroup] = useState<any>({});
    const [groupID] = useState(location.pathname.split('/')[2]);
    const [current, setCurrent] = useState(location.pathname.split('/')[3]);
    const [ready, setReady] = useState(false);

    useEffect(() => {
        // Fetch the group data
        fetch(`/api/v2/groups/${groupID}`, {
            headers: {
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
            },
        })
            .then((response) => {
                console.log(response);
                if (response.status === 404) {
                    addNotification({
                        type: 'error',
                        title: 'Pack not found',
                        description: 'The pack you are trying to access does not exist.',
                        persistent: true,
                    });

                    return {name: 'Pack not found'};
                } else if (response.status === 403) {
                    addNotification({
                        type: 'error',
                        title: 'Pack is private',
                        description: 'You are not a member of this pack.',
                        persistent: true,
                    });

                    return {name: 'Pack is private'};
                } else {
                    return response.json();
                }
            })
            .then((data) => {
                setGroup(data);

                if (data.meta) {
                    getMemberGroups(yipnyap_constants.currentUser?.id).then(() => {
                        setReady(true);
                    });
                }
            });
    }, [groupID])

    useEffect(() => {
        setCurrent(location.pathname.split('/')[3]);
    }, [location.pathname])

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
            navigator: {
                heading: group.name,
                subNavigation: [{
                    name: 'Pack Home',
                    description: '',
                    href: `groups/${groupID}/`,
                    icon: HomeIcon,
                }, {
                    name: 'Members',
                    description: '',
                    href: `groups/${groupID}/members/`,
                    icon: UserGroupIcon,
                }, {
                    name: 'Announcements',
                    description: '',
                    href: `groups/${groupID}/announcements/`,
                    icon: MegaphoneIcon,
                }, ...(
                    group.meta?.pivot.current ? [{
                        name: <span className="inline-flex">Moderate <ArrowUpRightIcon className="w-4"/></span>,
                        description: '',
                        href: `groups/${groupID}/moderate/`,
                        icon: ShieldCheckIcon,
                    }] : []
                )],
            },
        });
    }, [groupID, group]);

    function render() {
        switch (current) {
            case 'members': {
                return (
                    <NGTable headers={['Name', 'Role', 'Joined', 'Blank']}
                             data={[...group.meta.members.data.map((member: any) => {
                                 return {
                                     user: member,
                                     role: member.role,
                                     date: member.date_joined * 1000,
                                     edit: () => {
                                         if (group.meta.pivot.current) {
                                             return (
                                                 <Link to={`moderate/members/${member.id}`}>
                                                     Edit
                                                 </Link>
                                             )
                                         } else {
                                             return (
                                                 <></>
                                             )
                                         }
                                     },
                                 }
                             })]}
                    />
                )
            }

            case 'announcements': {
                return (
                    <div
                        className="bg-box shadow border-b border-default rounded-default">
                        <div className="flex p-4 highlight-white/5 rounded-default">
                            <div className="flex-shrink-0">
                                <InformationCircleIcon className="h-5 w-5 text-alt-2" aria-hidden="true"/>
                            </div>
                            <div className="ml-3">
                                <h3 className="text-sm font-medium text-alt-2">
                                    Eager, are we?
                                </h3>
                                <div className="mt-2 text-sm text-alt-2">
                                    <p>
                                        Announcements are only available to a society.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                )
            }

            default: {
                return (
                    <ActivityFilterableList
                        order="DESC"
                        groupID={groupID}
                        perPage={5}
                        element="NGContent"
                        className="m-auto p-8 max-w-3xl space-y-4"/>
                )
            }
        }
    }

    function joinGroup() {
        fetch(`/api/v2/groups/${groupID}/members`, {
            method: 'POST',
            headers: {
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
            },
        }).then(async (response) => {
            const data = await response.json();
            if (response.status === 200) {
                window.location.reload();
            } else {
                addNotification({
                    type: 'error',
                    title: 'Error',
                    message: data.message || response.statusText,
                });
            }
        })
    }

    return (
        <NGBody>
            {!ready ? (
                <NGSkeleton/>
            ) : (
                 <>
                     {/* TODO: Move this as it's own component */}
                     <div className="shadow relative z-10 pb-8 rounded-default bg-box">
                         <img className="rounded-default aspect-banner object-cover"
                              src={group.banner || `${yipnyap_constants.yipnyap_url}/img/illustrations/home/fox-in-snowy-oasis.webp`}
                              alt="Profile cover"/>
                         <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                             <div className="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                                 <div className="flex">
                                     <img
                                         className="bg-default h-24 w-24 rounded-default ring-4 ring-white dark:ring-neutral-800 sm:h-32 sm:w-32"
                                         src={group.avatar || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                                         alt=""/>
                                 </div>
                                 <div
                                     className="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                                     <div className="sm:hidden md:block mt-6 min-w-0 flex-1">
                                         <h1 className="text-2xl font-bold text-default truncate">
                                             {group.name}
                                         </h1>
                                         {/* Small @username */}
                                         <div className="flex items-center">
                                             <p className="text-sm font-medium text-alt-2 truncate">
                                                 @{group.slug || group.name}
                                             </p>
                                         </div>
                                     </div>

                                     <div
                                         className="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                                         {group.meta.members.is_member ? (
                                             <NGButton>
                                                 <UserPlusIcon
                                                     className="-ml-1 mr-2 h-5 w-5 text-neutral-400 dark:text-white"
                                                     aria-hidden="true"/>
                                                 <span>Leave Group</span>
                                             </NGButton>
                                         ) : (
                                              <NGButton onClick={joinGroup}>
                                                  <UserPlusIcon
                                                      className="-ml-1 mr-2 h-5 w-5 text-neutral-400 dark:text-white"
                                                      aria-hidden="true"/>
                                                  <span>Join Group</span>
                                              </NGButton>
                                          )}
                                     </div>
                                 </div>
                             </div>
                             <div className="hidden sm:block md:hidden mt-6 min-w-0 flex-1">
                                 <h1 className="text-2xl font-bold text-default truncate">
                                     {group.name}
                                 </h1>
                             </div>
                             <div className="block mt-6 min-w-0 flex-1 text-default">
                                 {/* Bio */}
                                 {group.description && (
                                     <p className="text-sm whitespace-pre-line">
                                         {group.description}
                                     </p>
                                 )}

                                 <div className="mt-2 flex flex-col text-sm text-alt-2">
                                     <div className="flex">
                                         <UserGroupIcon className="flex-shrink-0 mr-1.5 h-5 w-5"
                                                        aria-hidden="true"/>
                                         <span>
                                             {group.meta.members.count} {group.meta.members.term || 'members'}
                                         </span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     {render()}
                 </>
             )}
        </NGBody>
    )
}


