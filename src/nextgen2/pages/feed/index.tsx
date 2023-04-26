import React from 'react';
import {NGBody, NGCard, NGFeedPost} from "@nextgen2/components";

export default function Feed() {
    const post = {
        id: '03A101',
        likes: 0,
        user: {
            username: 'Test',
        },
        timestamp: 0,
        replies: [{
            id: '03I401',
            likes: 0,
            user: {
                username: 'Test 2',
            },
            timestamp: 0,
            children: <>
                <p>Thats hot</p>
            </>,
            replies: [{
                id: '03I401',
                likes: 0,
                user: {
                    username: 'Test 3',
                },
                timestamp: 0,
                children: <>
                    <p>seek help</p>
                </>,
            }],
        }, {
            id: '03I401',
            likes: 0,
            user: {
                username: 'Test',
            },
            timestamp: 0,
            children: <>
                <p>weeeee</p>
            </>,
        }],
        body: 'This is a test post',
    }
    return (
        <NGBody>
            <div className="max-w-3xl lg:max-w-7xl mx-auto sm:grid sm:grid-cols-12 sm:gap-8">
                <main className="sm:col-span-8">
                    <NGFeedPost post={post}></NGFeedPost>
                </main>
                <aside className="hidden sm:block sm:col-span-4">
                    <div className="sticky top-0 space-y-4">
                        {yipnyap_constants.currentUser?.username && (
                            <NGCard
                                title={<p className="text-sm leading-5 text-neutral-500">
                                    <b className="text-secondary">
                                        {yipnyap_constants.currentUser?.online_count === 1 ? 'Only you' : yipnyap_constants.currentUser?.online_count}
                                    </b>
                                    {yipnyap_constants.currentUser?.online_count > 1 ? ' people' : ''} are
                                    online this minute.
                                </p>}
                                wellBody={true}
                            >
                                {yipnyap_constants.currentUser?.online_count < 3 && (
                                    <p className="text-sm leading-5 text-neutral-500">
                                        Yipnyap is better with others! Tell 'em to join or login.
                                    </p>
                                )}
                            </NGCard>
                        )}

                        <NGCard
                            title={<h3 className="text-primary font-extrabold">
                                Help us make Yipnyap more comfy
                            </h3>}
                            wellBody={true}>
                            <p className="text-sm leading-5 text-neutral-500">
                                Help us make a chill, joyful, and welcoming experience by joining in
                                on the conversation!
                            </p>
                            <div className="mt-3 text-sm leading-5">
                                <a
                                    className="font-medium text-primary hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
                                    href="https://discord.gg/wrCGpAB"
                                    target="_blank"
                                >
                                    Join the Discord &rarr;
                                </a>
                            </div>
                        </NGCard>
                    </div>
                </aside>
            </div>
        </NGBody>
    )
}