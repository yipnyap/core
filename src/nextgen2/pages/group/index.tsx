/**
 * Groups page
 *
 * @author: Rekkisomo
 * @version: ui2
 */

import {HomeIcon, MegaphoneIcon, ShieldCheckIcon, UserGroupIcon} from '@heroicons/react/24/solid';
import {
    ArrowPathIcon, ArrowUpRightIcon, InformationCircleIcon, UserMinusIcon, UserPlusIcon,
} from '@heroicons/react/20/solid';
// @ts-ignore
import ActivityFilterableList from '@legacy/component/activity/ActivityFilterableList';
import {getMemberGroups} from '@legacy/router/v2/members/get';
import {getGroup, joinGroup, leaveGroup} from '@nextgen2/api/groups';
import {Group} from '@nextgen2/api/groups/types';
import {NGBody, NGButton, NGHeading, NGSkeleton, NGTable} from '@nextgen2/components';
import {useNotification} from '@nextgen2/providers/Notification.provider';
import {useHeading} from '@nextgen2/providers/PageHeading.provider';
import moment from 'moment';
import React, {useEffect, useState} from 'react';
import {Link, useLocation, useNavigate} from 'react-router-dom';

export default function GroupsIndex() {
    const location = useLocation();
    const navigate = useNavigate();
    const [, setHeading] = useHeading();
    const [, addNotification] = useNotification();
    const [group, setGroup] = useState<Group>();
    const [groupID] = useState(location.pathname.split('/')[2]);
    const [current, setCurrent] = useState(location.pathname.split('/')[3]);
    const [ready, setReady] = useState(false);
    const [communicating, setCommunicating] = useState(false);

    useEffect(() => {
        // Fetch the group data
        getGroup(groupID)
            .then((data) => {
                setGroup(data);

                if (data.meta) {
                    getMemberGroups(yipnyap_constants.currentUser?.id).then(() => {
                        setReady(true);
                    });
                }
            }).catch((error) => {
            addNotification({
                type: 'error',
                title: 'Error',
                message: error.message,
                persistent: true,
            });
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
                heading: group?.name,
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
                    group?.meta.pivot?.current && group.meta.pivot.current !== 'Member' ? [{
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
                             data={[...group?.meta.members.data.map((member: any) => {
                                 return {
                                     user: member,
                                     role: member.pivot.current,
                                     date: member.date_joined * 1000,
                                     edit: () => {
                                         if (group.meta.pivot?.current && group.meta.pivot.current !== 'Member') {
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
                             }) || []]}
                    />
                )
            }

            case 'announcements': {
                return (
                    <div
                        className="bg-box shadow border-b border-default rounded-default">
                        <div className="flex p-4 highlight-white/5 rounded-default">
                            <div className="flex-shrink-0">
                                <InformationCircleIcon className="h-5 w-5 text-default-alt" aria-hidden="true"/>
                            </div>
                            <div className="ml-3">
                                <h3 className="text-sm font-medium text-default-alt">
                                    Eager, are we?
                                </h3>
                                <div className="mt-2 text-sm text-default-alt">
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

    function joinGroupHandler() {
        setCommunicating(true);
        joinGroup(groupID).then(() => {
            window.location.reload();
        }).catch((error) => {
            setCommunicating(false);
            addNotification({
                type: 'error',
                title: 'Error',
                message: error.message,
            });
        });
    }

    function leaveGroupHandler() {
        if (group?.meta.pivot.current === 'Leader') {
            return navigate(`/groups/${groupID}/moderate/delete/`);
        }

        setCommunicating(true);
        leaveGroup(groupID).then(() => {
            window.location.reload();
        }).catch((error) => {
            setCommunicating(false);
            addNotification({
                type: 'error',
                title: 'Error',
                message: error.message,
            });
        });
    }

    return (
        <NGBody>
            {!ready ? (
                <NGSkeleton/>
            ) : (
                 <>
                     {/* "Group is missing its Leader" jumbo warning if 'orphan' is true */}
                     {group?.meta.orphan && (
                         <div className="bg-red-600 shadow border-b border-default rounded-default">
                             <div className="flex p-4 highlight-white/5 rounded-default">
                                 <div className="flex-shrink-0">
                                     <InformationCircleIcon className="h-5 w-5 text-white" aria-hidden="true"/>
                                 </div>
                                 <div className="ml-3">
                                     <h3 className="text-sm font-medium text-white">
                                         This pack is missing a leader
                                     </h3>
                                     <p className="mt-2 text-sm text-red-50">
                                         This pack's leader left the pack, and
                                         no one has been appointed to take their
                                         place. This pack is currently in a
                                         state of limbo, and will be deleted if
                                         the leader does not return.
                                     </p>
                                 </div>
                             </div>
                         </div>
                     )}
                     {/* TODO: Move this as it's own component */}
                     <div className="shadow relative z-10 pb-8 rounded-default bg-box">
                         <img className="rounded-default aspect-banner object-cover"
                              src={group?.banner || `${yipnyap_constants.yipnyap_url}/img/illustrations/home/fox-in-snowy-oasis.webp`}
                              alt="Profile cover"/>
                         <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                             <div className="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                                 <div className="flex">
                                     <img
                                         className="bg-default h-24 w-24 rounded-default ring-4 ring-white dark:ring-neutral-800 sm:h-32 sm:w-32"
                                         src={group?.avatar || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                                         alt=""/>
                                 </div>
                                 <div
                                     className="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                                     <div className="sm:hidden md:block mt-6 min-w-0 flex-1">
                                         <NGHeading>
                                             {group?.name}
                                         </NGHeading>
                                         {/* Small @username */}
                                         <div className="flex items-center">
                                             <p className="text-sm font-medium text-default-alt truncate">
                                                 @{group?.slug || group?.name}
                                             </p>
                                         </div>
                                     </div>

                                     <div
                                         className="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                                         {group?.meta.pivot?.current ? (
                                             <NGButton variant="danger" onClick={leaveGroupHandler}>
                                                 {communicating ? (
                                                     <ArrowPathIcon
                                                         className="-ml-1 mr-2 animate-spin h-5 w-5 text-white"/>
                                                 ) : (
                                                      <UserMinusIcon
                                                          className="-ml-1 mr-2 h-5 w-5 text-white"
                                                          aria-hidden="true"/>
                                                  )}
                                                 <span>Leave Pack</span>
                                             </NGButton>
                                         ) : (
                                              <NGButton onClick={joinGroupHandler}>
                                                  {communicating ? (
                                                      <ArrowPathIcon
                                                          className="-ml-1 mr-2 animate-spin h-5 w-5"/>
                                                  ) : (
                                                       <UserPlusIcon
                                                           className="-ml-1 mr-2 h-5 w-5"
                                                           aria-hidden="true"/>
                                                   )}
                                                  <span>Join Pack</span>
                                              </NGButton>
                                          )}
                                     </div>
                                 </div>
                             </div>
                             <div className="hidden sm:block md:hidden mt-6 min-w-0 flex-1">
                                 <NGHeading>
                                     {group?.name}
                                 </NGHeading>
                             </div>
                             <div className="block mt-6 min-w-0 flex-1 text-default">
                                 {/* Bio */}
                                 {group?.description && (
                                     <p className="text-sm whitespace-pre-line">
                                         {group.description}
                                     </p>
                                 )}

                                 <div className="mt-2 flex flex-col text-sm text-default-alt">
                                     <div className="flex">
                                         <UserGroupIcon className="flex-shrink-0 mr-1.5 h-5 w-5"
                                                        aria-hidden="true"/>
                                         <span>
                                             {group?.meta.members.count} {group?.meta.members.term || 'members'}
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


