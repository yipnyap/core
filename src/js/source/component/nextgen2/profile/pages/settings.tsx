import React, {useEffect} from "react";
import {useLocation} from "react-router-dom";
import {Cog6ToothIcon, PaintBrushIcon, QuestionMarkCircleIcon} from "@heroicons/react/24/outline";
import {ArrowUpRightIcon} from "@heroicons/react/20/solid";
import {useHeading} from "../../../../providers/PageHeading.provider";

// @ts-ignore
import ProfileSettingsScreen from '../../../legacy/settings/ProfileSettingsScreen.js';
import SettingsSkin from "./settings/skin";

export default function SettingsGeneral() {
    const [, setHeading] = useHeading();
    const location = useLocation();

    useEffect(() => {
        setHeading({
            heading: location.pathname === '/settings/' ? 'Settings' : null,
            padding: location.pathname !== '/settings/skin',
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
                        name: 'Profile Skin',
                        description: '',
                        href: '/settings/skin',
                        icon: PaintBrushIcon,
                        current: location.pathname === '/settings/skin',
                    },
                    {
                        name: <span className='inline-flex'>More <ArrowUpRightIcon className='w-4'/></span>,
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
        <>
            {
                location.pathname === '/settings/' && <ProfileSettingsScreen/>
            }
            {
                location.pathname === '/settings/skin' && <SettingsSkin/>
            }
        </>
    )
}