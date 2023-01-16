import React, {useEffect, useState} from "react";
import {useLocation} from "react-router-dom";

import './badges.module.css';

export default function ProfileBadges({...props}: any) {
    const location = useLocation();
    const [badges, setBadges] = useState<{
        id: number;
        name: string;
        description: string;
        image: string;
        deluxe?: boolean;
        secret?: boolean;
    }[]>([]);
    useEffect(() => {
        fetch(`/api/v2/member/${props.userID}/badges`).then(async (res) => {
            const json = await res.json();
            setBadges(json);
        });
    }, [location.pathname]);

    return (
        <div className="flex flex-col">
            {/* Header */}
            <div className="text-2xl font-bold leading-none text-default mb-12">
                Badge Showcase
            </div>

            <div className="max-w-lg grid gap-5 lg:grid-cols-3 lg:max-w-none">
                {badges.map((badge) => {
                    return (
                        <div key={badge.id} className={`${badge.deluxe ? 'relative use-snapper-engine bg-deluxe-shimmer' : ''} bg-box flex flex-col rounded-lg shadow-lg overflow-hidden`}>
                            <div className="flex-1 p-6 flex flex-col justify-between">
                                <div className="flex-1">
                                    <img src={badge.image} className="h-32 mx-auto" />
                                    {badge.secret ? null : (
                                        <div className="block mt-2">
                                            <p className="text-xl font-semibold text-default">{badge.name}</p>
                                            <p className="mt-3 text-base text-alt break-words">{badge.description}</p>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </div>
    )
}