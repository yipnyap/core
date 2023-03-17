import React, {useRef, useState} from 'react';
// @ts-ignore
import {buildClassObject} from '@nextgen2/utils/ColourScheme.utils';
import {
    BookOpenIcon, CalendarIcon, ChatBubbleBottomCenterIcon, ClockIcon, PhotoIcon, UserIcon, UsersIcon, ViewColumnsIcon,
} from '@heroicons/react/20/solid';
import {NGCard} from '../NGCard';
// @ts-ignore
import GroupManagePopup from '@legacy/component/group/GroupManagePopup.js';

export declare interface NGNewUserOnboardingType {
    theme?: any;
    children?: React.ReactNode;
}

export const NGNewUserOnboardingTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

const NewUserStartingPoints = [{
    title: 'Create a Post',
    description: 'A simple text post, or a multi-content story with embeds and images, or just dump your entire portfolio, you got 5GB 😎',
    anchor: 'create_post',
    icon: ChatBubbleBottomCenterIcon,
    background: 'bg-green-500',
}, {
    title: 'Create a Group',
    description: 'Create some random niche group. We don\'t care.',
    event: 'create_group',
    icon: UsersIcon,
    background: 'bg-rose-500',
}, {
    title: 'Read a Guide',
    description: 'We try to keep our guides up to date, but they\'re not always perfect.',
    to: `/category/guides/`,
    icon: BookOpenIcon,
    background: 'bg-purple-500',
}, {
    title: 'Join a Group',
    description: 'Groups are great for communities, or even just a group of friends.',
    to: '/groups/',
    icon: UsersIcon,
    background: 'bg-fuchsia-500',
}, {
    title: 'Customise your profile',
    description: 'Upload a profile picture, add a bio, header, etc.',
    to: '/settings/',
    icon: UserIcon,
    background: 'bg-blue-500',
}, {
    title: 'Just explore',
    description: 'You won\'t ever see this again!',
    event: 'doHideOnboarding',
    icon: ClockIcon,
    background: 'bg-cyan-500',
}]
export default function NGNewUserOnboarding({...props}: NGNewUserOnboardingType) {
    let theme = buildClassObject(NGNewUserOnboardingTheming, props.theme || undefined);
    const [hideOnboarding, setHideOnboarding] = useState(false);
    const groupManagePopupTriggerRef = useRef(null);

    function eventTrigger(event: string | undefined) {
        switch (event) {
            case 'doHideOnboarding':
                doHideOnboarding();
                break;
        }
    }

    function doHideOnboarding() {
        setHideOnboarding(true);
        yipnyap_constants.setDipswitch('hide_onboarding', true);
    }

    return (
        <>
            {!hideOnboarding && (
                <NGCard
                    className="overflow-visible px-12 py-6 rounded-xl highlight-white/5 bg-gradient-to-b from-green-500/5">
                    <div>
                        <h2 className="text-lg font-medium">Welcome to
                            Yipnyap, {yipnyap_constants.currentUser?.display_name}!</h2>
                        <p className="mt-1 text-sm text-default-alt">
                            Welcome to Yipnyap! Below are some things you can do to ✨customize✨ your profile, and get
                            started on
                            Yipnyap.
                        </p>
                        <ul role="list"
                            className="mt-6 border-t border-b border-default py-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            {NewUserStartingPoints.map((item, itemIdx) => (
                                <li key={itemIdx} className="flow-root">
                                    <div>
                                        <div
                                            className="relative -m-2 p-2 flex items-center space-x-4 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700 focus-within:ring-2 focus-within:ring-blue-500">
                                            <div
                                                className={classNames(item.background, 'flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-lg')}
                                            >
                                                <item.icon className="h-6 w-6 text-white" aria-hidden="true"/>
                                            </div>
                                            <div>
                                                <h3 className="text-sm font-medium">
                                                    {item.event === 'create_group' && (
                                                        <>
                                                            <a href="src/nextgen2/components/NGNewUserOnboarding#"
                                                               className="focus:outline-none"
                                                               ref={groupManagePopupTriggerRef}
                                                            >
                                                                <span className="absolute inset-0" aria-hidden="true"/>
                                                                {item.title}
                                                                <span aria-hidden="true"> &rarr;</span>
                                                            </a>
                                                            <GroupManagePopup
                                                                groupManagePopupTriggerRef={groupManagePopupTriggerRef}
                                                                loggedUser={yipnyap_constants.currentUser}
                                                                groupPreviewDescription="Create a new group"/>
                                                        </>
                                                    ) || (
                                                        <a
                                                            href={item.anchor ? `#onboarding-${item.anchor}` : (
                                                                item.to ? item.to : '#'
                                                            )}
                                                            onClick={() => {
                                                                eventTrigger(item.event)
                                                            }}
                                                            className="focus:outline-none">
                                                            <span className="absolute inset-0" aria-hidden="true"/>
                                                            {item.title}
                                                            <span aria-hidden="true"> &rarr;</span>
                                                        </a>
                                                    )}
                                                </h3>
                                                <p className="mt-1 text-sm text-default-alt">{item.description}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            ))}
                        </ul>
                    </div>
                </NGCard>
            )}
        </>
    );
}
