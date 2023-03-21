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
import {NGBody, NGTable} from '@nextgen2/components';
import PageModerateDashboard from '@nextgen2/pages/group/moderate/dashboard';
import PageModerateMembers from '@nextgen2/pages/group/moderate/members';
import PageModerateRoles from '@nextgen2/pages/group/moderate/roles';
import {useHeading} from '@nextgen2/providers/PageHeading.provider';
import React, {useEffect, useState} from 'react';
import {Link, useLocation} from 'react-router-dom';

export interface Group {
    id: number;
    name: string;
    description?: string;
    avatar?: string;
    banner?: string;
    meta: {
        pivot: {
            current: 'Leader' | 'Admin' | 'Mod' | null;
        }; members: {
            count: number; active: number; term: string; data: any[];
        }
    }
}

function Render({...props}: { group: Group }) {
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
                <PageModerateMembers group={group}/>
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
    const [groupID, setGroupID] = useState<string>(location.pathname.split('/')[2]);
    const [group, setGroup] = useState<Group>({
        avatar: '',
        banner: '',
        description: '',
        meta: {
            pivot: {
                current: null,
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
                    href: `${hrefPrefix}/members`,
                    icon: UserGroupIcon,
                }, {
                    name: 'Complaints',
                    description: 'View and act on any complaints made against the group.',
                    href: `${hrefPrefix}/complaints`,
                    icon: MegaphoneIcon,
                }, {
                    name: 'Path to Society',
                    new: true,
                    description: 'See how far the group is to becoming a society.',
                    href: `${hrefPrefix}/society`,
                    icon: BuildingOffice2Icon,
                }, {
                    name: 'Roles',
                    new: true,
                    description: 'Manage the roles of the group.',
                    href: `${hrefPrefix}/roles`,
                    icon: FlagIcon,
                }, {
                    name: 'Child Groups',
                    new: true,
                    description: 'Manage any child groups linked to this group.',
                    href: `${hrefPrefix}/child-groups`,
                    icon: Square3Stack3DIcon,
                }],
            },
        });
    }, [group.name])

    useEffect(() => {
        fetch(`/api/v2/groups/${groupID}`, {
            headers: {
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
            },
        })
            .then(res => res.json())
            .then(data => {
                if (!data.meta.pivot.current) {
                    // Redirect user to group
                    window.location.href = `/groups/${group.id}/`;
                } else {
                    setGroup(data);
                }
            });
    }, [groupID]);

    return (
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
                    <Render group={group}/>
                </div>
            </div>
        </NGBody>
    )
}