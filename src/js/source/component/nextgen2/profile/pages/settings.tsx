import React, {useEffect} from "react";
import {Cog6ToothIcon, QuestionMarkCircleIcon} from "@heroicons/react/24/outline";
import {useHeading} from "../../../../providers/PageHeading.provider";

// @ts-ignore
import ProfileSettingsScreen from '../../../legacy/settings/ProfileSettingsScreen.js';

export default function SettingsGeneral() {
    const [, setHeading] = useHeading();

    useEffect(() => {
        setHeading({
            heading: "Settings",
            padding: true,
            navigator: {
                subNavigation: [
                    {
                        name: 'General',
                        description: '',
                        href: '/settings/',
                        icon: Cog6ToothIcon,
                        current: location.pathname === '/settings/',
                    },
                    {
                        name: 'More',
                        description: 'Go to Legacy Settings',
                        href: `/${yipnyap_constants.currentUser.username}/settings`,
                        target: '_blank',
                        icon: QuestionMarkCircleIcon,
                        current: false,
                    }
                ]
            }
        })
    }, [location.pathname])

    return (
        <div className="p-6">
            <ProfileSettingsScreen />
        </div>
    )
}