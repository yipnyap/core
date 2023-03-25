import React, {useEffect, useState} from 'react';
import {useLocation} from "react-router-dom";
import {NGSkeleton} from "@nextgen2/components";
import {checkIfDateIsNewer, dateDifference} from "@nextgen2/utils/Dates.utils";

export default function Notifications() {
    // Grouping states
    const [groupsState, setGroupsState] = useState<any[]>([]);
    const [unsupportedNotifications, setUnsupportedNotifications] = useState<any[]>([]);

    // Ready state
    const [ready, setReady] = useState(false);
    const location = useLocation();

    function orchestrateGrouping(
        intake: any,
        groups: any[],
    ) {
        const typeCapitalized = intake.type.charAt(0).toUpperCase() + intake.type.slice(1);
        let group = groups.find((group) => group.type === typeCapitalized);

        // Replace _ with space
        intake.action = intake.action.replace(/_/g, ' ');

        // Capitalize each word in the notification's action, keeping spaces
        intake.action = intake.action.split(' ').map((word: string) => {
            return word.charAt(0).toUpperCase() + word.slice(1);
        }).join(' ');

        // If group doesn't exist, create it
        if (!group) {
            group = {
                type: typeCapitalized,
                notifications: [intake],
                latestDate: intake.date * 1000
            }
        } else {
            // Get last notification in array's date
            const latestDate = group.notifications[group.notifications.length - 1]?.date;
            const newDate = intake.date * 1000;

            // If the new date is newer than the latest date, set it as the latest date
            checkIfDateIsNewer(newDate, latestDate).then((date) => {
                if (date.isNewer) group.latestDate = newDate;
            });

            // Push notification to array
            group.notifications.push(intake);

            // Sort notifications by date
            group.notifications.sort((a: { date: number; }, b: { date: number; }) => {
                return b.date - a.date;
            });

            // Remove notifications that are older than 30 days
            group.notifications = group.notifications.filter((notification: { date: number; }) => {
                return new Date().getTime() + (1000 * 60 * 60 * 24 * 30) > notification.date * 1000;
            })
        }

        // Merge the groups array with the new group
        groups = groups.filter((group) => group.type !== intake.type);
        groups.push(group);

        // Sort groups by latest date
        groups.sort((a: { latestDate: number; }, b: { latestDate: number; }) => {
            return b.latestDate - a.latestDate;
        });

        return groups;
    }

    // Generate React elements from groups array
    function generateReactElements() {
        return groupsState.map((group) => {
            return (
                <div className="p-8 bg-box rounded-default highlight-white/5 space-y-4">
                    <div className="flex flex-col">
                        <div className="flex flex-row items-center justify-between">
                            <h3 className="text-lg">{group.type}</h3>
                            <p className="text-sm text-neutral-500">{dateDifference(group.latestDate, new Date(), true).unit}</p>
                        </div>
                    </div>
                    <div className="flex flex-col space-y-4">
                        {group.notifications.map((notification: {
                            data: {
                                user: {
                                    avatar: any;
                                    username: string | number | boolean | React.ReactElement<any, string | React.JSXElementConstructor<any>> | React.ReactFragment | React.ReactPortal | null | undefined;
                                };
                            };
                            action: string | number | boolean | React.ReactElement<any, string | React.JSXElementConstructor<any>> | React.ReactFragment | React.ReactPortal | null | undefined;
                        }, i: React.Key | null | undefined) => (
                            <div key={i} className="flex flex-row items-center justify-between">
                                <div className="flex flex-row items-center space-x-2">
                                    <div className="w-10 h-10 rounded-full bg-box" style={{
                                        background: `url(${notification.data.user.avatar}) no-repeat center center/cover`,
                                    }}></div>
                                    <div className="flex flex-col">
                                        <p>{notification.data.user.username}</p>
                                        <p className="text-sm text-neutral-500">{notification.action}</p>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            )
        })
    }

    useEffect(() => {
        fetch('/api/v2/notifications', {
            method: 'GET',
            headers: {
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
            }
        }).then(r => r.json()).then((data) => {
            let i = 0;
            let unsupported = [];
            let groups: any[] = [];
            for (const notification of data) {
                i++;

                if (notification.data.length === 0) {
                    unsupported.push(notification);
                } else {
                    groups = orchestrateGrouping(notification, groups);
                }

                if (i === data.length) {
                    setGroupsState(groups);
                    setUnsupportedNotifications(unsupported);
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
                    {unsupportedNotifications.length > 0 && (
                        <p className="text-sm text-neutral-500">
                            {unsupportedNotifications.length} unsupported notifications were found.
                            If you're fine with it, you can <a href="#" className="text-primary-500">send them</a>
                            to us so we can investigate!
                        </p>
                    )}
                </div>
                <div className="space-y-6">
                    {/* Notification list */}
                    <div className="flex flex-col space-y-4">
                        {!ready && (<NGSkeleton/>)}
                        {ready && (
                            <>
                                {generateReactElements()}
                            </>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}