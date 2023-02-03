import React, {useState} from 'react';
// @ts-ignore
import {buildClassObject} from "../../utils/ColourScheme.utils";
import {
    CalendarIcon,
    ChatBubbleBottomCenterIcon, ClockIcon,
    PhotoIcon,
    UserIcon, UsersIcon,
    ViewColumnsIcon
} from "@heroicons/react/20/solid";
import {NGCard} from "../NGCard";
import {Link} from "react-router-dom";

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

const NewUserStartingPoints = [
    {
        title: 'Create a Yap',
        description: 'A simple text post, or a multi-page story with embeds and images.',
        to: '/post/new',
        icon: ChatBubbleBottomCenterIcon,
        background: 'bg-green-500',
    },
    {
        title: 'Create an Event',
        description: 'Schedule a meet, a party, or even a convention!',
        icon: CalendarIcon,
        background: 'bg-rose-500',
    },
    {
        title: 'Create a Gallery',
        description: 'Great for collections of images, or a portfolio.',
        icon: PhotoIcon,
        background: 'bg-purple-500',
    },
    {
        title: 'Create a Group',
        description: 'Groups are great for communities, or even just a group of friends.',
        icon: UsersIcon,
        background: 'bg-fuchsia-500',
    },
    {
        title: 'Customise your profile',
        description: 'Upload a profile pictures, and add a bio.',
        icon: UserIcon,
        background: 'bg-blue-500',
    },
    {
        title: 'Just explore for now',
        description: 'You can always come back to this page later!',
        icon: ClockIcon,
        background: 'bg-cyan-500',
    },
]
export default function NGNewUserOnboarding({...props}: NGNewUserOnboardingType) {
    let theme = buildClassObject(NGNewUserOnboardingTheming, props.theme || undefined)

    return (
        <NGCard>
            <div>
                <h2 className="text-lg font-medium">Welcome to
                    Yipnyap, {yipnyap_constants.currentUser?.display_name}!</h2>
                <p className="mt-1 text-sm text-default-alt">
                    Welcome to Yipnyap! Below are some things you can do to ✨customize✨ your profile, and get started on
                    Yipnyap.
                </p>
                <ul role="list"
                    className="mt-6 border-t border-b border-default py-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    {NewUserStartingPoints.map((item, itemIdx) => (
                        <li key={itemIdx} className="flow-root">
                            <Link to={item.to || '/'}>
                                <div
                                    className="relative -m-2 p-2 flex items-center space-x-4 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700 focus-within:ring-2 focus-within:ring-blue-500">
                                    <div
                                        className={classNames(
                                            item.background,
                                            'flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-lg'
                                        )}
                                    >
                                        <item.icon className="h-6 w-6 text-white" aria-hidden="true"/>
                                    </div>
                                    <div>
                                        <h3 className="text-sm font-medium">
                                            <a href="#" className="focus:outline-none">
                                                <span className="absolute inset-0" aria-hidden="true"/>
                                                {item.title}
                                                <span aria-hidden="true"> &rarr;</span>
                                            </a>
                                        </h3>
                                        <p className="mt-1 text-sm text-default-alt">{item.description}</p>
                                    </div>
                                </div>
                            </Link>
                        </li>
                    ))}
                </ul>
                <div className="mt-4 flex">
                    <a href="#" className="text-sm font-medium text-blue-600 hover:text-blue-500">
                        Or explore freely and completely hide this<span aria-hidden="true"> &rarr;</span>
                    </a>
                </div>
            </div>
        </NGCard>
    );
}
