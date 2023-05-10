import React, {Fragment, useEffect, useRef, useState} from 'react';
import {NGBody, NGButton, NGCard, NGFeedPost, NGSkeleton} from '@nextgen2/components';
import EditorJS from '@editorjs/editorjs';
import Blocks from 'editorjs-blocks-react-renderer';
import InfiniteScroll from 'react-infinite-scroll-component';

// Editor Components
// @ts-ignore
import Header from '@editorjs/header';
// @ts-ignore
import NestedList from '@editorjs/nested-list';
// @ts-ignore
import Paragraph from '@editorjs/paragraph';
// @ts-ignore
import Quote from '@editorjs/quote';
// @ts-ignore
import Marker from '@editorjs/marker';
// @ts-ignore
import Underline from '@editorjs/underline';
// @ts-ignore
import Table from '@editorjs/table';

import {PaperClipIcon, UserCircleIcon} from '@heroicons/react/20/solid';
import {Listbox, Transition} from '@headlessui/react';

function classNames(...classes: string[]) {
    return classes.filter(Boolean).join(' ')
}

export default function Feed() {
    const ejInstance = useRef<EditorJS | null>(null);
    const [target, setTarget] = useState<any>(null);
    const [posts, setPosts] = useState<any>([]);
    const [postsReady, setPostsReady] = useState<boolean>(false);
    const [postsHasMore, setPostsHasMore] = useState<boolean>(false);
    const [postsCurrentPage, setPostsCurrentPage] = useState<number>(1);

    const initEditor = () => {
        const editor = new EditorJS({
            holder: 'UserPostEditor',
            autofocus: true,

            tools: {
                underline: Underline,
                table: Table,
                header: {
                    class: Header,
                    shortcut: 'CMD+SHIFT+H',
                },
                list: {
                    class: NestedList,
                    inlineToolbar: true,
                    config: {
                        defaultStyle: 'unordered'
                    }
                },
                paragraph: {
                    class: Paragraph,
                    inlineToolbar: true,
                },
                Marker: {
                    class: Marker,
                    shortcut: 'CMD+SHIFT+M',
                },
                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+O',
                    config: {
                        quotePlaceholder: 'Enter a quote',
                        captionPlaceholder: 'Quote\'s author',
                    },
                },
            },

            onReady: () => {
                ejInstance.current = editor;
            },
            onChange: async () => {
                let content = await editor.saver.save();

                console.log(content);
            }
        });
    };

    const fetchPosts = () => {
        fetch(`/api/v2/feed/?user=${''}&page=${postsCurrentPage}`, {
            headers: {
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
            }
        }).then(res => res.json()).then(res => {
            setPosts([...posts, ...res.posts]);
            setPostsReady(true);
            setPostsHasMore(res.hasMore);
            setPostsCurrentPage(postsCurrentPage + 1);
        });
    }

    useEffect(() => {
        fetchPosts();

        if (ejInstance.current === null && yipnyap_constants.currentUser) {
            initEditor();
        }

        return () => {
            ejInstance?.current?.destroy();
            ejInstance.current = null;
        };
    }, []);

    const createPost = async () => {
        let content = await ejInstance.current?.saver.save();

        fetch(`/api/v2/feed/post`, {
            method: 'POST',
            headers: {
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                content: content,
                target: target?.id
            })
        }).then(res => res.json()).then(res => {
            setPosts([res[0], ...posts]);
        });
    }

    return (
        <NGBody>
            <div className="max-w-3xl">
                {yipnyap_constants.currentUser?.dipswitch?.PendingVerifiedDeprecationAck && (
                    <>
                        {/* Comics deprecation notice */}
                        {yipnyap_constants.currentUser?.username === 'voidhound_' && (
                            <div className="flex flex-col mb-12">
                                <div className="flex flex-col space-y-4 sm:justify-between">
                                    <div className="flex items-center space-x-2">
                                        <img className="h-10 w-10"
                                             style={{
                                                 imageRendering: 'pixelated'
                                             }}
                                             src={`${yipnyap_constants.yipnyap_url}/img/emoji/night-with-stars.gif`}
                                             alt=""/>

                                        <h1 className="text-2xl font-bold leading-tight text-default">
                                            Comics have been sunset.
                                        </h1>
                                    </div>
                                    <p className="text-sm text-default-alt">
                                        You are seeing this as you have an active comic. This feature, unused, has been removed with
                                        no current plans to bring it back (unless there is a demand for it). Posts made for a comic
                                        can still be seen in your feed. Thank you for your understanding.
                                    </p>
                                    <div className="text-sm text-tertiary">
                                        <span>Features removed:</span>
                                        <ul className="list-disc list-inside">
                                            <li>Viewing comics</li>
                                            <li>Creating comics</li>
                                            <li>Appending comics</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        )}

                        {/* Verified program deprecation notice */}
                        <div className="flex flex-col mb-12">
                            <div className="flex flex-col space-y-4 sm:justify-between">
                                <div className="flex items-center space-x-2">
                                    <img className="h-10 w-10"
                                         style={{
                                             imageRendering: 'pixelated'
                                         }}
                                         src={`${yipnyap_constants.yipnyap_url}/img/emoji/night-with-stars.gif`}
                                         alt=""/>
                                    <h1 className="text-2xl font-bold leading-tight text-default">
                                        Verified program has been sunset.
                                    </h1>
                                </div>
                                <p className="text-sm text-default-alt">
                                    You are seeing this as you are currently verified. This feature has been merged with
                                    the Partner program. Your current badge will be removed, and all application methods
                                    have been removed. You will be invited to the Partner program if you are eligible.
                                    Just keep doing what you're doing, and keep using Yipnyap, and you'll be invited in
                                    due time.
                                </p>
                                <p className="text-sm text-default-alt">
                                    😸📣🎉 If you want to help spread the word about Yipnyap, we have a brand new referral
                                    program, called Promoter. You will get a badge next to your name, a green display name,
                                    and direct access to the Yipnyap team. You can apply for this program in the settings
                                    page.
                                </p>
                                <p className="text-sm text-default-alt">
                                    We understand that this may be disappointing, but we hope you understand. Thank you for
                                    using Yipnyap, even if you're new or haven't been on in a while. We appreciate you, and
                                    we hope you continue to use Yipnyap. As stated previously, you will be invited to the
                                    Partner program if you are eligible.
                                </p>

                                {/* Acknowledge button */}
                                <div className="flex justify-end">
                                    <NGButton onClick={() => {
                                        yipnyap_constants.setDipswitch('PendingVerifiedDeprecationAck', false);
                                    }}>
                                        Acknowledge
                                    </NGButton>
                                </div>
                            </div>
                        </div>
                    </>
                )}

                <div className="lg:max-w-7xl sm:grid sm:grid-cols-12 sm:gap-8">
                    <main className="space-y-8 sm:col-span-8">
                        {yipnyap_constants.currentUser && (
                            <NGCard className="relative z-10 overflow-visible">
                                <div className="flex space-x-3">
                                    <div className="flex-shrink-0">
                                        <img className="h-10 w-10 rounded-full"
                                             src={yipnyap_constants.currentUser?.avatar || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                                             alt=""/>
                                    </div>
                                    <div className="min-w-0 flex-1 flex flex-col justify-center">
                                        <a href={`/${yipnyap_constants.currentUser?.username}`}
                                           className="font-medium text-default cursor-pointer hover:underline">
                                            {yipnyap_constants.currentUser?.displayName || yipnyap_constants.currentUser?.username}
                                        </a>
                                        <span className="text-sm text-default-alt cursor-pointer hover:underline">
                                    @{yipnyap_constants.currentUser?.username}
                                </span>
                                    </div>
                                </div>

                                <div id="UserPostEditor" className="mt-4 mb-12 text-sm text-neutral-700 dark:text-neutral-50"/>

                                <div className="inset-x-px">
                                    <div className="flex flex-nowrap justify-end pb-2">
                                        <Listbox as="div" value={target} onChange={setTarget} className="flex-shrink-0">
                                            {({open}) => (
                                                <>
                                                    <Listbox.Label className="sr-only">Assign</Listbox.Label>
                                                    <div className="relative">
                                                        <Listbox.Button
                                                            className="relative inline-flex items-center rounded-default py-2 px-2 bg-box-alt text-sm font-medium text-default-alt whitespace-nowrap sm:px-3">
                                                            {target === null ? (
                                                                <UserCircleIcon
                                                                    className="flex-shrink-0 h-5 w-5 text-default-alt sm:-ml-1"
                                                                    aria-hidden="true"/>
                                                            ) : (
                                                                <img src={target.avatar} alt=""
                                                                     className="flex-shrink-0 h-5 w-5 rounded-full"/>
                                                            )}

                                                            <span
                                                                className={classNames(
                                                                    target === null ? '' : 'text-gray-900',
                                                                    'hidden truncate sm:ml-2 sm:block'
                                                                )}
                                                            >
                                                            {target === null ? 'Send to...' : target.name}
                                                        </span>
                                                        </Listbox.Button>

                                                        <Transition
                                                            show={open}
                                                            as={Fragment}
                                                            leave="transition ease-in duration-100"
                                                            leaveFrom="opacity-100"
                                                            leaveTo="opacity-0"
                                                        >
                                                            <Listbox.Options
                                                                className="absolute right-0 z-10 mt-1 w-52 bg-box shadow max-h-56 rounded-lg py-3 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                                                {yipnyap_constants.currentUser?.groups?.map((group: any) => (
                                                                    <Listbox.Option
                                                                        key={group.id}
                                                                        className={({active}) =>
                                                                            classNames(
                                                                                active ? 'bg-box-alt' : '',
                                                                                'cursor-default select-none relative py-2 px-3'
                                                                            )
                                                                        }
                                                                        value={group}
                                                                    >
                                                                        <div className="flex items-center">
                                                                            {group.avatar ? (
                                                                                <img src={group.avatar} alt=""
                                                                                     className="flex-shrink-0 h-5 w-5 rounded-full"/>
                                                                            ) : (
                                                                                <UserCircleIcon
                                                                                    className="flex-shrink-0 h-5 w-5 text-default-alt"
                                                                                    aria-hidden="true"/>
                                                                            )}

                                                                            <span
                                                                                className="ml-3 block font-medium truncate">{group.name}</span>
                                                                        </div>
                                                                    </Listbox.Option>
                                                                ))}
                                                            </Listbox.Options>
                                                        </Transition>
                                                    </div>
                                                </>
                                            )}
                                        </Listbox>
                                    </div>
                                    <div
                                        className="border border-x-0 border-b-0 border-t border-solid border-neutral-300 pt-2 flex justify-between items-center space-x-3 dark:border-neutral-700">
                                        <div className="flex">
                                            <button
                                                type="button"
                                                className="-ml-2 -my-2 rounded-full px-3 py-2 inline-flex items-center text-left text-gray-400 group"
                                            >
                                                <PaperClipIcon className="-ml-1 h-5 w-5 mr-2 group-hover:text-gray-500"
                                                               aria-hidden="true"/>
                                                <span className="text-sm text-gray-500 group-hover:text-gray-600 italic">Attach a file</span>
                                            </button>
                                        </div>
                                        <div className="flex-shrink-0">
                                            <NGButton
                                                variant="primary"
                                                className="inline-flex"
                                                onClick={createPost}
                                            >
                                                Create
                                            </NGButton>
                                        </div>
                                    </div>
                                </div>
                            </NGCard>
                        )}

                        {!postsReady && (
                            <NGSkeleton />
                        )}

                        {postsReady && (
                            <>
                                {posts.length !== 0 && (
                                    <InfiniteScroll
                                        dataLength={posts.length}
                                        next={fetchPosts}
                                        hasMore={postsHasMore}
                                        loader={<NGSkeleton dontAlternate />}
                                        endMessage={
                                            <p className="text-sm text-neutral-500 text-center">
                                                And just like that, you've reached the end of it all.<br/>
                                                <span className="font-bold">No more posts to show.</span>
                                            </p>
                                        }
                                        scrollableTarget="NGBody"
                                        className="space-y-8"
                                    >
                                        {posts.map((post: any) => (
                                            <NGFeedPost key={post.id} post={post}>
                                                {typeof post.content === 'object' ? (
                                                    <article className="prose dark:prose-invert">
                                                        <Blocks data={post.content} config={{
                                                            code: {
                                                                className: "language-js block whitespace-pre overflow-x-scroll bg-box-alt"
                                                            },
                                                            delimiter: {
                                                                className: "border border-2 w-16 mx-auto"
                                                            },
                                                            embed: {
                                                                className: "border-0"
                                                            },
                                                            header: {
                                                                // className: "font-bold"
                                                            },
                                                            marker: {
                                                                className: "bg-yellow-200"
                                                            },
                                                            image: {
                                                                className: "w-full max-w-screen-md",
                                                                actionsClassNames: {
                                                                    stretched: "w-full h-80 object-cover",
                                                                    withBorder: "border border-2",
                                                                    withBackground: "p-2",
                                                                }
                                                            },
                                                            list: {
                                                                className: "list-inside"
                                                            },
                                                            paragraph: {
                                                                className: "text-sm",
                                                                actionsClassNames: {
                                                                    alignment: "text-{alignment}", // This is a substitution placeholder: left or center.
                                                                }
                                                            },
                                                            quote: {
                                                                className: "py-3 px-5 italic font-serif"
                                                            },
                                                            table: {
                                                                className: "table-auto"
                                                            }
                                                        }}/>
                                                    </article>
                                                ) : post.content}
                                            </NGFeedPost>
                                        ))}
                                    </InfiniteScroll>
                                )}
                            </>
                        )}
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
            </div>
        </NGBody>
    )
}