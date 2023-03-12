import {Cog6ToothIcon} from '@heroicons/react/20/solid';
import {UserPlusIcon} from '@heroicons/react/24/solid';
import {getMemberGroups} from '@legacy/router/v2/members/get';
import {NGBody, NGNewUserOnboarding, NGSkeleton} from '@nextgen2/components';
import {NGCTACard} from '@nextgen2/components/NGCTACard';
import {NGGroupCard} from '@nextgen2/components/NGGroupCard';
import {useNotification} from '@nextgen2/providers/Notification.provider';
import {LocalThemeContext} from '@nextgen2/providers/Theme.provider';
import React, {useEffect, useState} from 'react';
import {Link, useLocation} from 'react-router-dom';

interface Props {
    theme: LocalThemeContext;
}

interface Group {
    id: number;
    name: string;
    description: string;
    avatar: string;
    banner: string;
    members: number;
    is_member: boolean;
    is_admin: boolean;
}

export default function Home({...props}: Props) {
    const [recommendedGroups, setRecommendedGroups] = useState([]);
    const [groups, setGroups] = useState<Group[]>([]);
    const [randomGroup, setRandomGroup] = useState<Group>();
    const [ready, setReady] = useState(false);
    const location = useLocation();
    const [, addNotification] = useNotification();

    useEffect(() => {
        let timeout: string | number | NodeJS.Timeout | undefined;
        timeout = setTimeout(() => {
            fetch(`/api/v2/groups?only=not_member&per_page=6`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
                },
            }).then(async (res) => {
                if (res.status === 200) {
                    const json = await res.json();
                    setGroups(json);
                }
            });

            if (yipnyap_constants.currentUser && !yipnyap_constants.currentUser.groups) {
                getMemberGroups(yipnyap_constants.currentUser.id).then((groups) => {
                    setGroups(groups);
                    setReady(true);

                    // set a random group
                    const randomGroup = groups[Math.floor(Math.random() * groups.length)];
                    setRandomGroup(randomGroup);
                });
            } else {
                setReady(true);

                if (yipnyap_constants.currentUser?.groups) {
                    // set a random group
                    const randomGroup = yipnyap_constants.currentUser.groups[Math.floor(Math.random() * yipnyap_constants.currentUser.groups.length)];
                    setRandomGroup(randomGroup);
                    setGroups(yipnyap_constants.currentUser.groups);
                }
            }
        }, 1500);

        return () => clearTimeout(timeout);
    }, [location.pathname]);

    function testNotif() {
        addNotification({
            title: 'Test Notification',
            message: 'This is a test notification',
        });
    }

    return (
        <NGBody>
            <div className="space-y-6">
                <div
                    className="hidden sm:block px-20 pt-10 pb-64 rounded-xl highlight-white/5"
                    style={{
                        background: `linear-gradient(rgba(0, 0, 0, ${props.theme.variant === 'dark' ? '0.3' : '0'}), rgba(0, 0, 0, 0.3)), url('${yipnyap_constants.yipnyap_url}/img/illustrations/home/fox-in-snowy-oasis.webp') center center / cover no-repeat`,
                    }}
                >
                    <div
                        className="rounded-default p-8 bg-neutral-800/75 backdrop-blur flex flex-col lg:w-1/2 space-y-4">
                        <h2 className="text-2xl text-white">Yipnyap is changing.</h2>
                        <p className="leading-normal text-white font-light">
                            Yipnyap is a place for furries to connect with each other, a place
                            that's built for furries, by furries. To achieve that, we need a
                            UI that's uncomplicated, easy, and fun to use. We're working hard
                            to make that happen!
                        </p>
                    </div>
                </div>

                {!ready && (
                    <NGSkeleton theme={props.theme}/>
                )}

                {/*<button className="bg-neutral-800/75 backdrop-blur rounded-default p-8" onClick={testNotif}>*/}
                {/*    send test notif*/}
                {/*</button>*/}

                {(
                    yipnyap_constants.currentUser && ready
                ) && (
                    <>
                        {yipnyap_constants.currentUser?.groups?.length >= 20 && (
                            <NGCTACard
                                title="⚠️ You're in an abnormal amount of packs"
                                description="Being in a lot of packs can slow down your browser as they're cached per
                                    session. If Yipnyap is slow, consider leaving some of them and see if that helps."
                            />
                        )}

                        {yipnyap_constants.currentUser?.friends?.length >= 20 && (
                            <NGCTACard
                                title="⚠️ You have an abnormal amount of friends"
                                description="Being friends with a ton of people can slow down your browser as they're
                                    cached per session.If Yipnyap is slow, consider unfriending some of them and see if that helps."
                            />
                        )}

                        {yipnyap_constants.currentUser?.friends?.length <= 3 && (
                            <NGCTACard
                                title="Add your friends"
                                description="Your friends could be here too~"
                                button={{
                                    text: 'Search for friends',
                                    icon: UserPlusIcon,
                                    to: '/members',
                                }}
                            />
                        )}

                        {!yipnyap_constants.currentUser?.tgid && (
                            <NGCTACard
                                title="Link your Telegram"
                                description="Telegram is used to ensure that you're a real person. It's also used to
                                    send you 2FA codes, notifications, and more!"
                                button={{
                                    text: 'Link Telegram',
                                    icon: Cog6ToothIcon,
                                    to: '/settings/telegram',
                                }}
                            />
                        )}
                    </>
                )}
            </div>

            {(
                yipnyap_constants.currentUser && !yipnyap_constants.currentUser?.dipswitch?.hide_onboarding
            ) && (
                <NGNewUserOnboarding/>
            )}

            {/* Grid of recommended groups */}
            <div className="flex flex-col space-y-4">
                <h2 className="text-2xl">Recommended Packs</h2>
                {recommendedGroups.length > 0 && (
                    <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        {recommendedGroups.map((group, i) => (
                            <NGGroupCard key={i} group={group}/>
                        ))}
                    </div>
                )}
                {recommendedGroups.length === 0 && (
                    <div className="flex flex-col space-y-2">
                        <p className="text-alt-2">
                            We couldn't recommend any packs for you! You're already
                            in all the good ones (～￣▽￣)～
                        </p>
                        {randomGroup && (
                            <p className="text-alt-2">
                                Check what's happening in
                                <Link to={`/groups/${randomGroup.id}/`} className="ml-1 items-center space-x-1">
                                    <img src={randomGroup.avatar} alt="Group Icon"
                                         className="inline w-6 h-6 rounded-full"/>
                                    <span>{randomGroup.name}</span>
                                </Link>!
                            </p>
                        )}
                    </div>
                )}
            </div>
        </NGBody>
    )
}
