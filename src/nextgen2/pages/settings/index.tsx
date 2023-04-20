import SettingsStorage from '@nextgen2/pages/settings/storage';
import React, {useEffect} from 'react';
import {useLocation} from 'react-router-dom';

// @ts-ignore
import {Flags} from 'react-feature-flags';

import {
    ArrowDownOnSquareStackIcon,
    BeakerIcon,
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
import SettingsLabs from "@nextgen2/pages/settings/labs";
import SettingsImport from "@nextgen2/pages/settings/import";

export default function SettingsGeneral() {
    const [, setHeading] = useHeading();
    const location = useLocation();

    useEffect(() => {
        setHeading({
            heading: location.pathname === '/settings/' ? 'Settings' : null,
            padding: true,
            navigator: {
                subNavigation: [{
                    name: 'General',
                    description: '',
                    href: '/settings/',
                    icon: Cog6ToothIcon,
                    current: location.pathname === '/settings/',
                }, {
                    name: 'Import to Yipnyap',
                    description: 'Import all your submissions from a supported service.',
                    href: '/settings/import/',
                    icon: ArrowDownOnSquareStackIcon,
                    new: true,
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
                    href: '/settings/storage/',
                    icon: ServerStackIcon,
                    current: location.pathname === '/settings/storage/',
                }, {
                    name: 'Labs',
                    description: '',
                    href: '/settings/labs/',
                    icon: BeakerIcon,
                    new: true,
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
            {location.pathname === '/settings/' && (
                <Flags
                    authorizedFlags={['NewProfileManagement']}
                    renderOff={() => <ProfileSettingsScreen/>}
                />
            )}

            {location.pathname === '/settings/import/' && <SettingsImport/>}

            {location.pathname === '/settings/telegram/' && <SettingsTelegram/>}

            {location.pathname === '/settings/skin/' && <SettingsSkin/>}

            {location.pathname === '/settings/accessibility/' && <SettingsAccessibility/>}

            {location.pathname === '/settings/social/' && <SocialSettingsScreen/>}

            {location.pathname === '/settings/storage/' && <SettingsStorage/>}

            {location.pathname === '/settings/labs/' && <SettingsLabs/>}
        </>
    )
}
