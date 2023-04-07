import {useTheme} from '@nextgen2/providers/Theme.provider';
import React, {Fragment, useEffect, useState} from 'react';

import getMember from '@legacy/router/v2/members/get';
import {Dialog, Transition} from '@headlessui/react';

// @ts-ignore
import ActivityFilterableList from '@legacy/component/activity/ActivityFilterableList.js';
// @ts-ignore
import ActivityPhotoList from '@legacy/component/activity/activity-media/activity-media-photo/ActivityPhotoList.js';
// @ts-ignore
import ActivityVideoList from '@legacy/component/activity/activity-media/activity-media-video/ActivityVideoList';
// @ts-ignore
import MemberFilterableList from '@legacy/component/filter/MemberFilterableList';
import {useHeading} from '@nextgen2/providers/PageHeading.provider';
import {
    Cog6ToothIcon, FaceSmileIcon, HomeIcon, PhotoIcon, TrophyIcon, VideoCameraIcon,
} from '@heroicons/react/24/solid';
import {ArrowUpRightIcon} from '@heroicons/react/20/solid';
import {useLocation} from 'react-router-dom';
import {NGContentNavigatorItemType} from '@nextgen2/components/Navigation/NGContentNavigator/NGContentNavigator';
import Arcana from './pages/special/arcana';
import ProfileBadges from './pages/badges';
import {NGBody, NGSkeleton, NGProfileHeader} from '@nextgen2/components';

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
        id: number; name: string; current: number; total: number;
    }
}

export function NextgenProfilesWelcomeModal() {
    let [isOpen, setIsOpen] = useState(localStorage.getItem('nextgen-profile-welcome-modal') === null);

    function closeModal() {
        setIsOpen(false);
        localStorage.setItem('nextgen-profile-welcome-modal', '1');
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
                    <div className="fixed inset-0 bg-black bg-opacity-25"/>
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
                            <Dialog.Panel
                                className="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                {/* Image */}
                                <div className="flex justify-center pb-6">
                                    <img
                                        src={`${yipnyap_constants.yipnyap_url}/img/illustrations/onboarding/maneki-neko.png`}
                                        alt="Beckoning maneki-neko in-between houseplant and figurine"/>
                                </div>
                                <Dialog.Title
                                    as="h3"
                                    className="text-lg font-medium leading-6 text-gray-900"
                                >
                                    Welcome to your profile!
                                </Dialog.Title>
                                <div className="mt-2 space-y-2">
                                    <p className="text-sm text-gray-500">
                                        This is where you can share your content, show off your achievements, and
                                        create a space for yourself on Yipnyap.
                                    </p>
                                    <div className="text-sm text-gray-500">
                                        You can also use this page to share your social media links, so that people can
                                        find you on other platforms. You can also add a bio, so that people can learn
                                        more
                                        about you! You can edit your profile by clicking the
                                        <Cog6ToothIcon className="inline ml-1 w-4 h-4"/> icon in the navigator.
                                    </div>
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
    const [theme, setTheme] = useTheme();
    const location = useLocation();
    let {userID} = props;

    if (!userID) {
        // Get username from url
        userID = location.pathname.split('/')[1];
    }

    const pageIsGabe = userID === 'voidhound_';
    const selfIsGabe = yipnyap_constants.currentUser?.username === 'voidhound_';

    useEffect(() => {
        let userBackgroundProcessingTimeout: string | number | NodeJS.Timeout | undefined;
        // If voidhound_, show "Arcana" tab
        if (pageIsGabe) {
            setUserSubNav([{
                name: 'Arcana',
                description: '',
                href: `/${userID}/arcana/`,
                icon: 'https://yipnyap.me/vault/@server/uploads/2022/12/dorito.png',
                current: location.pathname === `/${userID}/arcana/`,
            }])
        }

        const userPromise = userID ? getMember(`@${userID}`, (
            2 + 4
        )) : null;
        userPromise?.then((user) => {
            console.log(user);
            setUser(user);

            userBackgroundProcessingTimeout = setTimeout(() => {
                const themeBackup = {...theme};
                if (user.ui_skin) {
                    if (user.ui_skin.background) themeBackup.background = user.ui_skin.background;
                    if (user.ui_skin.accent) themeBackup.accent = user.ui_skin.primary;

                    setTheme(themeBackup);
                }

                setTheme(themeBackup)
            }, 1000)
        });

        return () => {
            const themeBackup = {...theme};
            delete themeBackup.background;

            setTheme(themeBackup);
            clearTimeout(userBackgroundProcessingTimeout);
        }
    }, [userID]);

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
            navigator: {
                subNavigation: [{
                    name: 'User Feed',
                    description: '',
                    href: `/${userID}/`,
                    icon: HomeIcon,
                    current: location.pathname === `/${userID}/`,
                }, ...userSubNav ?? [], {
                    name: 'Photos',
                    description: '',
                    href: `/${userID}/photos/`,
                    icon: PhotoIcon,
                    current: location.pathname === `/${userID}/photos/`,
                }, {
                    name: 'Videos',
                    description: '',
                    href: `/${userID}/videos/`,
                    icon: VideoCameraIcon,
                    current: location.pathname === `/${userID}/videos/`,
                }, {
                    name: 'Friends',
                    description: '',
                    href: `/${userID}/friends/`,
                    icon: FaceSmileIcon,
                    current: location.pathname === `/${userID}/friends/`,
                }, {
                    name: 'Badges',
                    description: '',
                    href: `/${userID}/badges/`,
                    icon: TrophyIcon,
                    current: location.pathname === `/${userID}/badges/`,
                }, ...yipnyap_constants.currentUser?.username === userID ? [{
                    name: <span className="inline-flex">Settings <ArrowUpRightIcon className="w-4"/></span>,
                    description: '',
                    href: '/settings/',
                    icon: Cog6ToothIcon,
                    current: false,
                }] : []],
            },
        })
    }, [location.pathname, userSubNav]);

    return (
        <NGBody>
            {!user && <NGSkeleton/>}
            {user && (
                <>
                    {location.pathname.startsWith(`/${userID}/arcana/`) ? (
                        <Arcana isGabe={selfIsGabe}/>
                    ) : (
                         <>
                             {(
                                 yipnyap_constants.currentUser?.username && yipnyap_constants.currentUser?.username === user.username
                             ) && <NextgenProfilesWelcomeModal/>}
                             {location.pathname !== `/${userID}/arcana/` && <NGProfileHeader
                                 user={user}
                                 loggedIn={yipnyap_constants.currentUser?.username?.length > 0}
                                 self={yipnyap_constants.currentUser?.username === user.username}
                             />}
                             <div className="m-auto p-8 max-w-3xl space-y-4">
                                 {location.pathname === `/${userID}/` && (
                                     <ActivityFilterableList userID={user.id} perPage={5} element="NGContent"/>
                                 )}

                                 {location.pathname.startsWith(`/${userID}/activity/`) && (
                                     <ActivityFilterableList userID={user.id}
                                                             activityID={location.pathname.split('/')[3]} perPage={5}
                                                             element="NGContent"/>
                                 )}

                                 {location.pathname === `/${userID}/photos/` && (
                                     <div className="bg-box p-8 rounded-xl">
                                         <ActivityPhotoList userID={user.id}
                                                            perPage={24}
                                                            order="DESC"/>
                                     </div>
                                 )}

                                 {location.pathname === `/${userID}/videos/` && (
                                     <div className="bg-box p-8 rounded-xl">
                                         <ActivityVideoList userID={user.id}
                                                            perPage={24}
                                                            order="DESC"/>
                                     </div>
                                 )}

                                 {location.pathname === `/${userID}/friends/` && (
                                     <div className="bg-box p-8 rounded-xl">
                                         <MemberFilterableList itemsPerPage={12}
                                                               userID={user.id}
                                         />
                                     </div>
                                 )}

                                 {location.pathname === `/${userID}/badges/` && (
                                     <div className="bg-box p-8 rounded-xl">
                                         <ProfileBadges userID={user.id}/>
                                     </div>
                                 )}
                             </div>
                         </>
                     )}
                </>
            )}
        </NGBody>
    )
}
