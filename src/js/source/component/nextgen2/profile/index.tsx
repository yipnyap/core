import React, {Fragment, useEffect, useState} from 'react';

import {NGProfileHeader} from '../../../nextgen/components/NGProfileHeader';
import getMember from "../../../router/v2/members/get";
import {Dialog, Transition} from "@headlessui/react";
// @ts-ignore
import ActivityFilterableList from '../../legacy/activity/ActivityFilterableList.js';
// @ts-ignore
import ActivityPhotoList from '../../legacy/activity/activity-media/activity-media-photo/ActivityPhotoList.js';
import {useHeading} from "../../../providers/PageHeading.provider";
import {Cog6ToothIcon, HomeIcon, PhotoIcon} from "@heroicons/react/24/outline";
import {useLocation} from "react-router-dom";
import {NGContentNavigatorItemType} from "../../../nextgen/components/NGContentNavigator/NGContentNavigator";

interface NGProfileType {
    id: number;
    username: string;
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
                                        You can now change your profile banner, avatar, bio,
                                        and more, from the profile page. You can also now add custom HTML to your
                                        profile, which can be used to add custom widgets.
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
        const userPromise = userID ? getMember(`@${userID}`, 2) : null;
        userPromise?.then((user) => {
            console.log(user);
            setUser(user);
            if (user.username === yipnyap_constants.currentUser.username) {
                setUserSubNav([
                    {
                        name: 'Settings',
                        description: '',
                        href: '/settings/',
                        icon: Cog6ToothIcon,
                        current: false,
                    }
                ])
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
                    {
                        name: 'Photos',
                        description: '',
                        href: `/${userID}/photos/`,
                        icon: PhotoIcon,
                        current: location.pathname === `/${userID}/photos/`
                    },
                    ...userSubNav ?? []
                ]
            }
        })
    }, [location.pathname, userSubNav])

    return (
        <>
            {
                user && (
                    <div className="m-auto p-8 max-w-3xl space-y-4">
                        {
                            (yipnyap_constants.currentUser.username && yipnyap_constants.currentUser.username === user.username) && <NextgenProfilesWelcomeModal />
                        }
                        <NGProfileHeader
                            user={user}
                            loggedIn={yipnyap_constants.currentUser}
                            self={yipnyap_constants.currentUser === user.username}
                            defaults={{
                                header: `${yipnyap_constants.yipnyap_url}/img/cover/default-cover.png`
                            }}
                        />

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
                    </div>
                )
            }
        </>
    )
}
