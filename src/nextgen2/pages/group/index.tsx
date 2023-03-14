/**
 * Groups page
 *
 * @author: Rekkisomo
 * @version: ui2
 */

import {HomeIcon, MegaphoneIcon, UserGroupIcon} from '@heroicons/react/24/solid';
import {InformationCircleIcon} from '@heroicons/react/20/solid';
// @ts-ignore
import ActivityFilterableList from '@legacy/component/activity/ActivityFilterableList';
import {getMemberGroups} from '@legacy/router/v2/members/get';
import {NGBody, NGSkeleton} from '@nextgen2/components';
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
                }],
            },
        });
    }, [groupID, group]);

    function render() {
        switch (current) {
            case 'members': {
                return (
                    <div className="flex flex-col">
                        <div className="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div className="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div
                                    className="bg-box shadow overflow-hidden border-b border-default rounded-default">
                                    <table className="min-w-full divide-y divide-default highlight-white/5">
                                        <thead>
                                        <tr>
                                            <th scope="col"
                                                className="px-6 py-3 text-left text-xs font-medium text-alt-2 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col"
                                                className="px-6 py-3 text-left text-xs font-medium text-alt-2 uppercase tracking-wider">
                                                Role
                                            </th>
                                            <th scope="col"
                                                className="px-6 py-3 text-left text-xs font-medium text-alt-2 uppercase tracking-wider">
                                                Joined
                                            </th>
                                            {group.meta.members.is_mod || group.meta.members.is_admin && (
                                                <th scope="col" className="relative px-6 py-3">
                                                    <span className="sr-only">Edit</span>
                                                </th>
                                            )}
                                        </tr>
                                        </thead>
                                        <tbody className="divide-y divide-default">
                                        {group.meta.members.data.map((member: {
                                            id: React.Key | null | undefined;
                                            avatar: string;
                                            display_name: string;
                                            username: string;
                                            role: string;
                                            date_joined: number;
                                        }) => (
                                            <tr key={member.id} className="hover:bg-box-alt">
                                                <Link to={`/${member.username}/`}>
                                                    <td className="px-6 py-4 whitespace-nowrap">
                                                        <div className="flex items-center">
                                                            <div className="flex-shrink-0 h-10 w-10">
                                                                <img className="h-10 w-10 rounded-full"
                                                                     src={member.avatar || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                                                                     alt=""/>
                                                            </div>
                                                            <div className="ml-4">
                                                                <div className="text-sm font-medium text-default">
                                                                    {member.display_name}
                                                                </div>
                                                                <div className="text-sm text-alt-2">
                                                                    @{member.username}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </Link>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <div className="text-sm text-alt-2">
                                                        {member.role || 'Guest'}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-alt-2">
                                                    {member.date_joined ? moment(member.date_joined * 1000).format('MMMM Do YYYY @ HH:mm') : 'Legacy'}
                                                </td>
                                                {group.meta.members.is_mod || group.meta.members.is_admin && (
                                                    <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <Link to={`/groups/${groupID}/moderate/members/${member.id}/`}
                                                              className="text-default hover:text-primary">
                                                            Edit
                                                        </Link>
                                                    </td>
                                                )}
                                            </tr>
                                        ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                         <UserGroupIcon className="flex-shrink-0 mr-1.5 h-5 w-5" aria-hidden="true"/>
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


