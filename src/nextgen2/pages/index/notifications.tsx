import React, {useEffect, useState} from 'react';
import {useLocation} from "react-router-dom";
import {NGSkeleton} from "@nextgen2/components";
import {dateDifference} from "@nextgen2/utils/Dates.utils";

export default function Notifications() {
    const [followNotifications, setFollowNotifications] = React.useState<any[]>([]);
    const [followLatestDateStr, setFollowLatestDateStr] = React.useState<string>();
    const [ready, setReady] = useState(false);
    const location = useLocation();

    useEffect(() => {
        fetch('/api/v2/notifications', {
            method: 'GET',
            headers: {
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
            }
        }).then(r => r.json()).then(data => {
            let i = 0;
            let latestDate;
            for (const notification of data) {
                i++;
                if (notification.type === 'follow') {
                    setFollowNotifications([...followNotifications, notification]);

                    // Check if the date is the latest, if so, set it as the latest date in `x hour(s) ago`
                    const newDate = notification.date * 1000;
                    const lastDate = new Date(latestDate || newDate);
                    if (newDate >= lastDate.getTime()) {
                        const diff = dateDifference(newDate);
                        setFollowLatestDateStr(`${diff.value} ${diff.unit} ago`);

                        latestDate = notification.date;
                    }
                }

                if (i === data.length) {
                    setReady(true);
                }
            }
        })
    }, [location.pathname]);

    return (
        <div className="flex justify-center m-auto lg:grid grid-cols-10 h-full">
            <div className="flex flex-col col-span-8 px-20 py-10 space-y-12 h-full overflow-y-auto">
                <div className="space-y-2">
                    <h2 className="text-2xl">Notifications</h2>
                    <p className="leading-normal">
                        Your notifications will appear here. They'll be grouped by type, and expire
                        after a while.
                    </p>
                </div>
                <div className="space-y-6">
                    {/* Notification list */}
                    <div className="flex flex-col space-y-4">
                        {!ready && (<NGSkeleton/>)}
                        {ready && (
                            <div className="p-8 bg-box rounded-default highlight-white/5 space-y-4">
                                <div className="flex flex-col">
                                    <div className="flex flex-row items-center justify-between">
                                        <h3 className="text-lg">New follows</h3>
                                        <p className="text-sm text-neutral-500">{followLatestDateStr}</p>
                                    </div>
                                    <p className="text-sm text-neutral-500">You have some new followers</p>
                                </div>
                                <div className="flex flex-col space-y-4">
                                    {followNotifications.map((notification, i) => (
                                        <div key={i} className="flex flex-row items-center justify-between">
                                            <div className="flex flex-row items-center space-x-2">
                                                <div className="w-10 h-10 rounded-full bg-box" style={{
                                                    background: `url(${notification.data.user.avatar}) no-repeat center center/cover`,
                                                }}></div>
                                                <div className="flex flex-col">
                                                    <p>{notification.data.user.name}</p>
                                                    <p className="text-sm text-neutral-500">Followed you</p>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}