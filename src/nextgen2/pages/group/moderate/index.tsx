import {
    BuildingOffice2Icon,
    BuildingStorefrontIcon,
    FlagIcon,
    HomeIcon,
    MegaphoneIcon,
    RocketLaunchIcon,
    Square3Stack3DIcon,
    UserGroupIcon,
} from '@heroicons/react/24/solid';
import {getGroup} from '@nextgen2/api/groups';
import {Group} from '@nextgen2/api/groups/types';
import {NGBody} from '@nextgen2/components';
import PageModerateDashboard from '@nextgen2/pages/group/moderate/dashboard';
import PageModerateOrphan from '@nextgen2/pages/group/moderate/dashboard/orphan';
import PageModerateMembers from '@nextgen2/pages/group/moderate/members';
import PageModerateRoles from '@nextgen2/pages/group/moderate/roles';
import {useHeading} from '@nextgen2/providers/PageHeading.provider';
import React, {useEffect, useState} from 'react';
import {useLocation} from 'react-router-dom';

function Render({...props}: {
    group: Group; communicatingState: [boolean, React.Dispatch<React.SetStateAction<boolean>>]
}) {
    const [group, setGroup] = useState<Group>(props.group);

    useEffect(() => {
        setGroup(props.group);
    }, [props.group]);

    switch (location.pathname.split('/')[4]) {
        case '': {
            return (
                <PageModerateDashboard group={group}/>
            )
        }

        case 'roles': {
            return (
                <PageModerateRoles group={group}/>
            )
        }

        case 'members': {
            return (
                <PageModerateMembers group={group} communicatingState={props.communicatingState}/>
            )
        }

        case 'delete': {
            return (
                <PageModerateOrphan group={group}/>
            )
        }

        default: {
            return (
                <span className="text-alt-2"><code>CientRouter::404</code> Not Found</span>
            )
        }
    }
}

export default function PageModerateIndex() {
    const location = useLocation();
    const [, setHeading] = useHeading();
    const [communicating, setCommunicating] = useState<boolean>(true);
    const [groupID, setGroupID] = useState<string>(location.pathname.split('/')[2]);
    const [group, setGroup] = useState<Group>({
        avatar: '',
        banner: '',
        description: '',
        meta: {
            pivot: {
                current: 'Member',
            },
            members: {
                active: 0,
                count: 0,
                data: [],
                term: '',
            },
        },
        name: 'Permission Check...',
        id: parseInt(groupID),
    });

    useEffect(() => {
        const hrefPrefix = `groups/${groupID}/moderate`
        setHeading({
            heading: null,
            padding: false,
            navigator: {
                heading: `${group.name} - Moderation`,
                subNavigation: [{
                    name: 'Dashboard',
                    description: '',
                    href: `${hrefPrefix}/`,
                    icon: HomeIcon,
                }, {
                    name: 'Members',
                    description: 'Manage any members of the group.',
                    href: `${hrefPrefix}/members/`,
                    icon: UserGroupIcon,
                }, {
                    name: 'Complaints',
                    description: 'View and act on any complaints made against the group.',
                    href: `${hrefPrefix}/complaints/`,
                    icon: MegaphoneIcon,
                }, {
                    name: 'Path to Society',
                    new: true,
                    description: 'See how far the group is to becoming a society.',
                    href: `${hrefPrefix}/society/`,
                    icon: BuildingOffice2Icon,
                }, {
                    name: 'Roles',
                    new: true,
                    description: 'Manage the roles of the group.',
                    href: `${hrefPrefix}/roles/`,
                    icon: FlagIcon,
                }, {
                    name: 'Child Groups',
                    new: true,
                    description: 'Manage any child groups linked to this group.',
                    href: `${hrefPrefix}/child-groups/`,
                    icon: Square3Stack3DIcon,
                }, ...group.meta.pivot.current === 'Leader' ? [{
                    name: 'Delete Group',
                    description: 'Delete the group and all of its data.',
                    href: `${hrefPrefix}/delete/`,
                    icon: BuildingStorefrontIcon,
                }] : []],
            },
        });
    }, [group.name])

    useEffect(() => {
        getGroup(groupID)
            .then(data => {
                if (!data.meta.pivot?.current || data.meta.pivot?.current === 'Member') {
                    // Redirect user to group
                    window.location.href = `/groups/${group.id}/`;
                } else {
                    setGroup(data);
                    setCommunicating(false);
                }
            });
    }, [groupID]);

    return (
        <div className="relative">
            <NGBody>
                {/* Managing ___ */}
                <div className="flex flex-col space-y-8">
                    <div className="space-y-4">
                        <h2 className="text-2xl">Managing {group.name}</h2>
                        <div className="flex flex-row items-center space-x-2">
                            <div className="w-8 h-8 rounded-full bg-box" style={{
                                background: `url(${group.avatar}) no-repeat center center/cover`,
                            }}></div>
                            <div className="flex flex-col">
                                <p>{group.name}</p>
                                {group.description && <p className="text-sm text-alt-2">{group.description}</p>}
                            </div>
                        </div>
                    </div>
                    <div className="flex flex-row space-x-4 w-full">
                        <Render group={group} communicatingState={[communicating, setCommunicating]}/>
                    </div>
                </div>
            </NGBody>

            {/* Top full-width "Communicating..." card */}
            {communicating && (
                <div className="fixed flex top-0 left-0 w-full bg-box h-16 m-auto z-50 justify-center items-center">
                    <div className="flex flex-row justify-center items-center space-x-2">
                        <img src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
                             className="w-6 h-6 animate-spin dark:invert"/>
                        <p className="text-sm">Communicating...</p>
                    </div>
                </div>
            )}
        </div>
    )
}