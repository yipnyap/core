import {BuildingOffice2Icon, HomeIcon, MegaphoneIcon, UserGroupIcon} from '@heroicons/react/24/solid';
import {NGBody} from '@nextgen2/components';
import {useHeading} from '@nextgen2/providers/PageHeading.provider';
import React, {useEffect, useState} from 'react';

interface Group {
    id: number;
    name: string;
    description?: string;
    avatar?: string;
    banner?: string;
    members?: number;
    is_member?: boolean;
    is_admin?: boolean;
    meta?: {
        members?: {
            count: number; active: number; term: string;
        }
    }
}

export default function PageModerateIndex() {
    const [, setHeading] = useHeading();
    const [groupID, setGroupID] = useState<string>(location.pathname.split('/')[2]);
    const [group, setGroup] = useState<Group>({
        name: 'Loading...',
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
                }],
            },
        });
    }, [group.name])

    useEffect(() => {
        fetch(`/api/v2/groups/${groupID}`)
            .then(res => res.json())
            .then(data => {
                setGroup(data);
            });
    }, [groupID]);

    return (
        <NGBody>
            {/* Managing ___ */}
            <div className="flex flex-col space-y-4">
                <h2 className="text-2xl">Managing {group.name}</h2>
                <div className="flex flex-row items-center space-x-2">
                    <div className="w-8 h-8 rounded-full bg-box" style={{
                        background: `url(${group.avatar}) no-repeat center center/cover`,
                    }}></div>
                    <div className="flex flex-col">
                        <h3 className="text-lg">{group.name}</h3>
                        {group.description && <p className="text-sm text-neutral-500">{group.description}</p>}
                    </div>
                </div>
            </div>
        </NGBody>
    )
}