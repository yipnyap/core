import React, {Fragment, useEffect, useState} from 'react';

import {NGProfileHeader} from '../../../nextgen/components/NGProfileHeader';
import getMember from "../../../router/v2/members/get";
import {Dialog, Transition} from "@headlessui/react";
// @ts-ignore
import ActivityFilterableList from '../../legacy/activity/ActivityFilterableList.js';
// @ts-ignore
import ActivityPhotoList from '../../legacy/activity/activity-media/activity-media-photo/ActivityPhotoList.js';
// @ts-ignore
import ActivityVideoList from '../../../component/legacy/activity/activity-media/activity-media-video/ActivityVideoList';
// @ts-ignore
import MemberFilterableList from '../../../component/legacy/filter/MemberFilterableList';
import {useHeading} from "../../../providers/PageHeading.provider";
import {
    Cog6ToothIcon,
    FaceSmileIcon,
    HomeIcon,
    PhotoIcon,
    TrophyIcon,
    VideoCameraIcon
} from "@heroicons/react/24/outline";
import {ArrowUpRightIcon} from "@heroicons/react/20/solid";
import {useLocation} from "react-router-dom";
import {NGContentNavigatorItemType} from "../../../nextgen/components/NGContentNavigator/NGContentNavigator";
import Arcana from "./pages/special/arcana";

interface NGProfileType {
    id: number;
    username: string;
    display_name: string;
    avatar: string;
    banner?: string;
    bio?: string;
    followers?: number;
    following?: number;
    verified?: boolean;
    rank?: {
        id: number;
        name: string;
        current: number;
        total: number;
    }
}

export function NextgenProfilesWelcomeModal() {
    let [isOpen, setIsOpen] = useState(localStorage.getItem('nextgen-profile-welcome-modal') === null);

    function closeModal() {
        setIsOpen(false);
        localStorage.setItem('nextgen-profile-welcome-modal', '1');
    }

    function openModal() {
        setIsOpen(true)
    }

    return (
        <Transition appear show={isOpen} as={Fragment}>
            <Dialog as="div" className="relative z-10" onClose={closeModal}>
                <Transition.Child
                    as={Fragment}
                    enter="ease-out duration-300"
                    enterFrom="opacity-0"
                    enterTo="opacity-100"
                    leave="ease-in duration-200"
                    leaveFrom="opacity-100"
                    leaveTo="opacity-0"
                >
                    <div className="fixed inset-0 bg-black bg-opacity-25" />
                </Transition.Child>

                <div className="fixed inset-0 overflow-y-auto">
                    <div className="flex min-h-full items-center justify-center p-4 text-center">
                        <Transition.Child
                            as={Fragment}
                            enter="ease-out duration-300"
                            enterFrom="opacity-0 scale-95"
                            enterTo="opacity-100 scale-100"
                            leave="ease-in duration-200"
                            leaveFrom="opacity-100 scale-100"
                            leaveTo="opacity-0 scale-95"
                        >
                            <Dialog.Panel className="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                {/* Image */}
                                <div className="flex justify-center pb-6">
                                    <img src={`${yipnyap_constants.yipnyap_url}/img/illustrations/onboarding/maneki-neko.png`} alt="Beckoning maneki-neko in-between houseplant and figurine" />
                                </div>
                                <Dialog.Title
                                    as="h3"
                                    className="text-lg font-medium leading-6 text-gray-900"
                                >
                                    Welcome to your new profile!
                                </Dialog.Title>
                                <div className="mt-2">
                                    <p className="text-sm text-gray-500">
                                        No more eyesore! You can now change your profile banner, avatar, bio, and more,
                                        from the profile page.
                                    </p>
                                </div>

                                <div className="mt-4">
                                    <button
                                        type="button"
                                        className="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        onClick={closeModal}
                                    >
                                        Got it!
                                    </button>
                                </div>
                            </Dialog.Panel>
                        </Transition.Child>
                    </div>
                </div>
            </Dialog>
        </Transition>
    )
}

export default function Profile({...props}) {
    const [user, setUser] = useState<NGProfileType | null>(null);
    const [userSubNav, setUserSubNav] = useState<NGContentNavigatorItemType[]>([]);
    const [, setHeading] = useHeading();
    const location = useLocation();
    let {userID} = props;

    if (!userID) {
        // Get username from url
        userID = location.pathname.split('/')[1];
    }

    useEffect(() => {
        // If voidhound_, show "Arcana" tab
        if (userID === 'rekkisomo') {
            setUserSubNav([
                {
                    name: 'Arcana',
                    description: '',
                    href: `/${userID}/arcana/`,
                    icon: 'https://yipnyap.xyz/vault/@server/uploads/2022/12/dorito.png',
                    current: location.pathname === `/${userID}/arcana/`,
                }
            ])
        }

        const userPromise = userID ? getMember(`@${userID}`, (2 + 4)) : null;
        userPromise?.then((user) => {
            console.log(user);
            setUser(user);
            if (user.ui_skin) {
                const cmuiContent = document.getElementById('cmui-entire-content');
                if (user.ui_skin.background) cmuiContent?.style.setProperty('background', user.ui_skin.background.replace('&amp;', '&'));
                if (user.ui_skin.primary) document.body.style.setProperty('--color-primary', user.ui_skin.primary);
            }
        });
    }, [userID, location.pathname]);

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
            navigator: {
                subNavigation: [
                    {
                        name: 'User Feed',
                        description: '',
                        href: `/${userID}/`,
                        icon: HomeIcon,
                        current: location.pathname === `/${userID}/`
                    },
                    ...userSubNav ?? [],
                    {
                        name: 'Photos',
                        description: '',
                        href: `/${userID}/photos/`,
                        icon: PhotoIcon,
                        current: location.pathname === `/${userID}/photos/`
                    },
                    {
                        name: 'Videos',
                        description: '',
                        href: `/${userID}/videos/`,
                        icon: VideoCameraIcon,
                        current: location.pathname === `/${userID}/videos/`
                    },
                    {
                        name: 'Friends',
                        description: '',
                        href: `/${userID}/friends/`,
                        icon: FaceSmileIcon,
                        current: location.pathname === `/${userID}/friends/`
                    },
                    {
                        name: 'Badges',
                        description: '',
                        href: `/${userID}/badges/`,
                        icon: TrophyIcon,
                        current: location.pathname === `/${userID}/badges/`
                    },
                    ...yipnyap_constants.currentUser.username === userID ? [{
                        name: <span className='inline-flex'>Settings <ArrowUpRightIcon className='w-4'/></span>,
                        description: '',
                        href: '/settings/',
                        icon: Cog6ToothIcon,
                        current: false,
                    }] : [],
                ]
            }
        })
    }, [location.pathname, userSubNav])

    return (
        <>
            {
                user && (
                    <>
                        {
                            location.pathname.startsWith(`/${userID}/arcana/`) ? (
                                <Arcana />
                            ) : (
                                <div className="m-auto p-8 max-w-3xl space-y-4">
                                    {
                                        (yipnyap_constants.currentUser.username && yipnyap_constants.currentUser.username === user.username) && <NextgenProfilesWelcomeModal />
                                    }
                                    {
                                        location.pathname !== `/${userID}/arcana/` &&  <NGProfileHeader
                                            user={user}
                                            loggedIn={yipnyap_constants.currentUser.username?.length > 0}
                                            self={yipnyap_constants.currentUser.username === user.username}
                                        />
                                    }

                                    {
                                        location.pathname === `/${userID}/` && (
                                            <ActivityFilterableList userID={user.id} perPage={5} element='NGContent' />
                                        )
                                    }

                                    {
                                        location.pathname === `/${userID}/photos/` && (
                                            <ActivityPhotoList  userID={user.id}
                                                                perPage={24}
                                                                order='DESC' />
                                        )
                                    }

                                    {
                                        location.pathname === `/${userID}/videos/` && (
                                            <ActivityVideoList  userID={user.id}
                                                                perPage={24}
                                                                order='DESC' />
                                        )
                                    }

                                    {
                                        location.pathname === `/${userID}/friends/` && (
                                            <MemberFilterableList itemsPerPage={12}
                                                                  userID={user.id}
                                            />
                                        )
                                    }
                                </div>
                            )
                        }
                    </>
                )
            }
        </>
    )
}
