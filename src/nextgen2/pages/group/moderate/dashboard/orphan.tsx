import {ArrowPathIcon, UserMinusIcon} from '@heroicons/react/20/solid';
import {leaveGroup} from '@nextgen2/api/groups';
import {NGButton, NGHeading} from '@nextgen2/components';
import React, {useState} from 'react';

export default function PageModerateOrphan({...props}: { group: any }) {
    const [communicating, setCommunicating] = useState(false);

    function leaveGroupHandler() {
        setCommunicating(true);
        leaveGroup(props.group.id).then(() => {
            window.location.href = `/groups/${props.group.id}/`;
        }).catch((err) => {
            setCommunicating(false);
            console.log(err);
        });
    }

    return (
        <div className="flex flex-col space-y-8">
            <div className="flex flex-col space-y-4">
                <NGHeading>
                    You're about to ditch what you've created
                </NGHeading>
                <div className="space-y-2">
                    <p className="text-default-alt">
                        You can always come back to this pack later, but if you
                        don't after a while, it will be deleted. Everyone
                        participating in this pack will be notified when they
                        next visit the pack's page.
                    </p>
                    <p className="text-default-alt">
                        If you need this pack to be deleted immediately, please{' '}
                        <a className="text-blue-500" href="https://work.yipnyap.me/">
                            create a task
                        </a>, or go to Yipnyap Legacy (accessible via Search,
                        or CTRL/⌘ + K, as "Create & Manage Groups").
                    </p>
                </div>
            </div>

            {/* Button */}
            <div className="flex flex-row space-y-4">
                <NGButton variant="danger" onClick={leaveGroupHandler}>
                    {communicating ? (
                        <ArrowPathIcon className="-ml-1 mr-2 animate-spin h-5 w-5 text-white"/>
                    ) : (
                         <UserMinusIcon
                             className="-ml-1 mr-2 h-5 w-5 text-white"
                             aria-hidden="true"/>
                     )}
                    <span>Leave Pack</span>
                </NGButton>
            </div>
        </div>

    )
}