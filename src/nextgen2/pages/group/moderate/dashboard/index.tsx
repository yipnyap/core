import {NGStatsGrid} from '@nextgen2/components';
import React, {useEffect, useState} from 'react';

export default function PageModerateDashboard({...props}: { group: any }) {
    const [group, setGroup] = useState<any>(props.group);

    useEffect(() => {
        setGroup(props.group);
    }, [props.group]);

    return (
        <>
            <NGStatsGrid stats={[{
                name: 'Members',
                stat: `${group.meta.members.count}`,
            }, {
                name: 'Active',
                stat: `${group.meta.members.active}`,
            }, {
                name: 'Status',
                stat: group.privacy === 'public' ? 'Public' : 'Private',
            }]}/>
        </>
    )
}