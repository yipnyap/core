import React, {useEffect} from 'react';
import {useLocation} from 'react-router-dom';
import {
    Cog6ToothIcon,
    CursorArrowRaysIcon,
    PaintBrushIcon,
    PaperAirplaneIcon,
    QuestionMarkCircleIcon,
    ServerStackIcon,
    ShareIcon,
} from '@heroicons/react/24/solid';
import {ArrowUpRightIcon} from '@heroicons/react/20/solid';
import {useHeading} from '@nextgen2/providers/PageHeading.provider';
// @ts-ignore
import ProfileSettingsScreen from '@legacy/component/settings/ProfileSettingsScreen.js';
// @ts-ignore
import SocialSettingsScreen from '@legacy/component/settings/SocialSettingsScreen.js';
// @ts-ignore
import AccountInfoSettingsScreen from '@legacy/component/settings/AccountInfoSettingsScreen.js';
import SettingsSkin from '@nextgen2/pages/settings/skin';
import SettingsAccessibility from '@nextgen2/pages/settings/accessibility';
import SettingsTelegram from '@nextgen2/pages/settings/telegram';

export default function SettingsGeneral() {
    const [, setHeading] = useHeading();
    const location = useLocation();

    useEffect(() => {
        setHeading({
            heading: location.pathname === '/settings/' ? 'Settings' : null,
            padding: location.pathname !== '/settings/skin/',
            navigator: {
                subNavigation: [{
                    name: 'General',
                    description: '',
                    href: '/settings/',
                    icon: Cog6ToothIcon,
                    current: location.pathname === '/settings/',
                }, {
                    name: 'Telegram',
                    description: 'Claim this account and configure Telegram notifcations, OTP, and more.',
                    href: '/settings/telegram/',
                    icon: PaperAirplaneIcon,
                    current: location.pathname === '/settings/telegram/',
                }, {
                    name: 'Profile Skin',
                    description: '',
                    href: '/settings/skin/',
                    icon: PaintBrushIcon,
                    current: location.pathname === '/settings/skin/',
                }, {
                    name: 'Accessibility',
                    description: 'Change font size, etc.',
                    href: '/settings/accessibility/',
                    icon: CursorArrowRaysIcon,
                    current: location.pathname === '/settings/accessibility/',
                }, {
                    name: 'Social',
                    description: '',
                    href: '/settings/social/',
                    icon: ShareIcon,
                    current: location.pathname === '/settings/social/',
                }, {
                    name: 'Storage',
                    description: '',
                    href: '/settings/kukiko-id/',
                    icon: ServerStackIcon,
                    current: location.pathname === '/settings/kukiko-id/',
                }, {
                    name: <span className="inline-flex">More <ArrowUpRightIcon className="w-4"/></span>,
                    description: 'Go to Legacy Settings',
                    href: `/${yipnyap_constants.currentUser?.username}/settings/`,
                    target: '_blank',
                    icon: QuestionMarkCircleIcon,
                    current: false,
                }],
            },
        })
    }, [location.pathname])

    return (
        <>
            {location.pathname === '/settings/' && <ProfileSettingsScreen/>}

            {location.pathname === '/settings/telegram/' && <SettingsTelegram/>}

            {location.pathname === '/settings/skin/' && <SettingsSkin/>}

            {location.pathname === '/settings/accessibility/' && <SettingsAccessibility/>}

            {location.pathname === '/settings/social/' && <SocialSettingsScreen/>}

            {location.pathname === '/settings/kukiko-id/' &&
                <div className="flex flex-col items-center justify-center h-full"><h1
                    className="text-2xl font-bold">Kukiko ID</h1> <p className="text-gray-500">Snap-in Unavailable. Go
                    to Legacy Settings.</p></div>}
        </>
    )
}
