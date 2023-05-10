import React, {Fragment, useEffect, useRef, useState} from 'react';
import moment from 'moment';
import {Menu, Transition} from '@headlessui/react';
import {
    ChatBubbleBottomCenterTextIcon, EllipsisHorizontalIcon, FlagIcon, HandThumbUpIcon, StarIcon,
} from '@heroicons/react/24/solid';
import {NGCard} from '../../Layout/NGCard';
import {ArrowsPointingOutIcon, ChatBubbleLeftIcon, PaperAirplaneIcon} from "@heroicons/react/20/solid";
import {NGAvatar, NGSlideover } from '@nextgen2/components';

export declare interface NGFeedPostDataType {
    id: string;
    likes?: number;
    user: {
        id: number,
        display_name: string,
        username: string,
        avatar: string,
        header: string,
        followers: number,
        following: number,
        posts: number,
        online: boolean,
    };
    content?: object | string;
    timestamp: number;
    likedParent?: boolean;
    replies?: NGFeedPostDataType[];
    tags?: string[];
    objects?: {
        id: string,
        url: string,
    }[]
}

export declare interface NGFeedPostType {
    post: NGFeedPostDataType
    theme?: any;
    children?: React.ReactNode;
}

export const NGFeedPostTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGFeedPost({...props}: NGFeedPostType) {
    const [postContent, setPostContent] = useState(props.post);
    const [selectedMedia, setSelectedMedia] = useState<any | null>(null);
    const [slideoverMediaOpen, setSlideoverMediaOpen] = useState(false);
    const [slideoverOpen, setSlideoverOpen] = useState(false);

    useEffect(() => {
        setSlideoverMediaOpen(!!selectedMedia);
    }, [selectedMedia]);

    useEffect(() => {
        if (!slideoverMediaOpen) setTimeout(() => setSelectedMedia(null), 150);
    }, [slideoverMediaOpen]);

    // @todo: move media slideover to its own component
    // Get the aspect ratio of the loaded media
    const [aspectRatio, setAspectRatio] = useState(1);

    useEffect(() => {
        if (slideoverOpen && postContent.objects && postContent.objects.length > 0) {
            const img = new Image();
            img.src = postContent.objects[0].url;
            img.onload = () => {
                const rounded = Math.round((img.width / img.height) * 100) / 100;
                console.log(`[📰 Feed Processor] Aspect ratio calc for natural expand: ${rounded} (${img.width}x${img.height})`);
                setAspectRatio(rounded);
            }
        }
    }, [slideoverOpen]);

    // @ts-ignore
    return (
        <>
            {selectedMedia && (
                <NGSlideover expandNatural open={[slideoverMediaOpen, setSlideoverMediaOpen]}>
                    <div>
                        <div className="aspect-w-10 aspect-h-7 block w-full overflow-hidden rounded-default">
                            <img
                                src={selectedMedia?.url}
                                alt=""
                                className="object-cover"
                            />
                        </div>
                        <div className="mt-4 flex items-start justify-between">
                            <div>
                                <h2 className="text-lg font-medium text-default">
                                    @{postContent.user.username}'s Image Details
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 className="font-medium text-default">Information</h3>
                        <dl className="mt-2 divide-y divide-gray-200 border-t border-b border-gray-200">
                            <div className="flex justify-between py-3 text-sm font-medium">
                                <dt className="text-default-alt">Key</dt>
                                <dd className="text-default">{selectedMedia?.id}</dd>
                            </div>

                            {postContent?.timestamp && (
                                <div className="flex justify-between py-3 text-sm font-medium">
                                    <dt className="text-default-alt">Post Upload Date</dt>
                                    <dd className="text-default">{new Date(postContent.timestamp * 1000).toLocaleDateString()}</dd>
                                </div>
                            )}

                            <div className="flex justify-between py-3 text-sm font-medium">
                                <dt className="text-default-alt">Tags</dt>
                                <dd className="text-default">{postContent?.tags?.join(', ') || 'None'}</dd>
                            </div>
                        </dl>
                    </div>
                </NGSlideover>
            )}

            <NGSlideover expandNatural={aspectRatio > 1.2} className={`${slideoverMediaOpen ? '-translate-x-24 will-change-transform transition-transform duration-150' : ''} will-change-transform transition-transform duration-150`} open={[slideoverOpen, setSlideoverOpen]}>
                <div className="flex space-x-3 rounded-default p-2 bg-box sticky top-0 z-50">
                    <div className="flex-shrink-0">
                        <NGAvatar image={postContent.user.avatar} online={postContent.user.online} />
                    </div>
                    <div className="min-w-0 flex-1 flex flex-col justify-center">
                        <a href={`/${postContent.user.username}`} className="font-medium text-default cursor-pointer hover:underline">
                            {postContent.user.display_name || postContent.user.username}
                        </a>
                        {postContent.timestamp && (
                            <a href={`/@!${postContent.id}`} className="text-sm text-default-alt cursor-pointer hover:underline">
                                <time
                                    dateTime={(postContent.timestamp * 1000).toString()}>
                                    {moment(postContent.timestamp * 1000).fromNow()}
                                </time>
                            </a>
                        )}
                    </div>
                </div>

                <div
                    className="mb-6 mt-4 text-sm text-neutral-700 space-y-4 dark:text-neutral-50">
                    {props.children}
                </div>

                {postContent?.objects && postContent.objects.length > 0 && (
                    <MediaGrid objects={postContent.objects} selectState={[selectedMedia, setSelectedMedia]} />
                )}

                {postContent?.replies && postContent.replies.length > 0 && (
                    <div className="px-4 py-4 sm:px-6 bg-box-alt rounded-default">
                        {yipnyap_constants.currentUser && (
                            <CommentBox className="mb-8" post={[postContent, setPostContent]} />
                        )}

                        <div className="flow-root">
                            <ul role="list" className="-mb-8">
                                {postContent.replies.map((reply) => (
                                    <RecursiveCommentThread key={reply.id} reply={reply} post={[postContent, setPostContent]} />
                                ))}
                            </ul>
                        </div>
                    </div>
                )}
            </NGSlideover>

            <NGCard noPadding>
                <div className="relative">
                    <div className="px-4 py-5 sm:px-6">
                        <div className="flex space-x-3">
                            <div className="flex-shrink-0">
                                <NGAvatar image={postContent.user.avatar} online={postContent.user.online} />
                            </div>
                            <div className="min-w-0 flex-1 flex flex-col justify-center">
                                <a href={`/${postContent.user.username}`} className="font-medium text-default cursor-pointer hover:underline">
                                    {postContent.user.display_name || postContent.user.username}
                                </a>
                                {postContent.timestamp && (
                                    <a href={`/@!${postContent.id}`} className="text-sm text-default-alt cursor-pointer hover:underline">
                                        <time
                                            dateTime={(postContent.timestamp * 1000).toString()}>
                                            {moment(postContent.timestamp * 1000).fromNow()}
                                        </time>
                                    </a>
                                )}
                            </div>
                            <div className="flex-shrink-0 self-center flex space-x-2">
                                <div className="relative inline-block text-left">
                                    <div>
                                        <ArrowsPointingOutIcon
                                            className="h-5 w-5 text-neutral-400 hover:text-neutral-600"
                                            onClick={() => setSlideoverOpen(true)}
                                        />
                                    </div>
                                </div>
                                <Menu as="div" className="relative inline-block text-left">
                                    <div>
                                        <Menu.Button
                                            className="rounded-full text-neutral-400 hover:text-neutral-600">
                                            <span className="sr-only">Open options</span>
                                            <EllipsisHorizontalIcon className="h-5 w-5"
                                                                    aria-hidden="true"/>
                                        </Menu.Button>
                                    </div>

                                    <Transition
                                        as={Fragment}
                                        enter="transition ease-out duration-100"
                                        enterFrom="transform opacity-0 scale-95"
                                        enterTo="transform opacity-100 scale-100"
                                        leave="transition ease-in duration-75"
                                        leaveFrom="transform opacity-100 scale-100"
                                        leaveTo="transform opacity-0 scale-95"
                                    >
                                        <Menu.Items
                                            className="origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                            <div className="py-1">
                                                <Menu.Item>
                                                    {({active}) => (
                                                        <a
                                                            href="src/nextgen/components/NGFeedPost/NGFeedPost#"
                                                            className={classNames(active ? 'bg-gray-100 text-neutral-900' : 'text-neutral-700', 'flex px-4 py-2 text-sm')}
                                                        >
                                                            <StarIcon
                                                                className="mr-3 h-5 w-5 text-neutral-400"
                                                                aria-hidden="true"/>
                                                            <span>Add to favorites</span>
                                                        </a>
                                                    )}
                                                </Menu.Item>
                                                <Menu.Item>
                                                    {({active}) => (
                                                        <a
                                                            href="src/nextgen/components/NGFeedPost/NGFeedPost#"
                                                            className={classNames(active ? 'bg-gray-100 text-neutral-900' : 'text-neutral-700', 'flex px-4 py-2 text-sm')}
                                                        >
                                                            <FlagIcon
                                                                className="mr-3 h-5 w-5 text-neutral-400"
                                                                aria-hidden="true"/>
                                                            <span>Report content</span>
                                                        </a>
                                                    )}
                                                </Menu.Item>
                                            </div>
                                        </Menu.Items>
                                    </Transition>
                                </Menu>
                            </div>
                        </div>
                        <div
                            className="mb-6 mt-4 text-sm text-neutral-700 space-y-4 dark:text-neutral-50">
                            {props.children}
                        </div>

                        {/* Post Objects (Images) */}
                        {postContent?.objects && postContent.objects.length > 0 && (
                            <MediaGrid objects={postContent.objects} selectState={[selectedMedia, setSelectedMedia]} post={postContent} truncate />
                        )}
                    </div>

                    {/* Floating "User is typing..." card */}
                    {/*<div className="absolute bottom-0 left-0 ml-4 sm:ml-6 bg-box-alt border-x border-t border-b-0 border-solid border-neutral-300 dark:border-neutral-700 rounded-tl-xl rounded-tr-xl">*/}
                    {/*    <div className="flex items-center space-x-2 px-4 py-2">*/}
                    {/*        <div className="flex-shrink-0">*/}
                    {/*            <img className="h-4 w-4 rounded-full"*/}
                    {/*                    src={postContent.user.avatar || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}*/}
                    {/*                    alt=""/>*/}
                    {/*        </div>*/}
                    {/*        <div className="min-w-0 flex-1">*/}
                    {/*            <p className="text-sm font-medium text-default cursor-pointer hover:underline">*/}
                    {/*                {postContent.user.username} is typing...*/}
                    {/*            </p>*/}
                    {/*        </div>*/}
                    {/*    </div>*/}
                    {/*</div>*/}
                </div>

                {/* Footer - Like & Share on left, rest of space taken up by a reply textbox with send icon on right */}
                <div className="px-4 py-4 sm:px-6 flex justify-between space-x-8 bg-box-alt border-t border-x-0 border-b-0 border-solid border-neutral-300 dark:border-neutral-700">
                    <div className="flex space-x-6">
                    <span
                        className="inline-flex items-center text-sm cursor-pointer hover:underline"
                        onClick={() => {
                            console.log('like')
                        }}
                    >
                        <HandThumbUpIcon className="h-5 w-5 text-neutral-400"
                                         aria-hidden="true"/>
                        <span className="ml-2">{postContent.likes || 'Like'}</span>
                    </span>
                        {yipnyap_constants.currentUser && (
                            <span
                                className="inline-flex items-center text-sm cursor-pointer hover:underline"
                                onClick={() => {
                                    console.log('like')
                                }}
                            >
                        <ChatBubbleBottomCenterTextIcon className="h-5 w-5 text-neutral-400" />
                    </span>
                        )}
                    </div>

                    {/* Textbox */}
                    {yipnyap_constants.currentUser && (
                        <CommentBox className="flex-1" truncate post={[postContent, setPostContent]} />
                    )}
                </div>

                {/* Replies */}
                {postContent?.replies && postContent.replies.length > 0 && (
                    <div className="px-4 py-4 sm:px-6 bg-box-alt">
                        <div className="flow-root">
                            <ul role="list" className="-mb-8">
                                {postContent.replies.map((reply) => (
                                    <>
                                        {/* @ts-ignore - postContent.replies isn't fucking undefined. */}
                                        <FeedListItem key={reply.id} reply={reply} showLine={reply.replies && reply.replies.length > 0} post={[postContent, setPostContent]} />
                                        {reply.replies && reply.replies.length > 0 && reply.replies.map((replyInside, replyInsideIdx) => (
                                            <>
                                                {/* @ts-ignore - fuck sake. */}
                                                <FeedListItem key={replyInside.id} reply={replyInside} showLine={replyInsideIdx !== reply.replies.length - 1} post={[postContent, setPostContent]} />
                                            </>
                                        ))}
                                    </>
                                ))}
                            </ul>
                        </div>
                    </div>
                )}
            </NGCard>
        </>
    );
}

function CommentBox({...props}: any) {
    const [postContent, setPostContent] = props.post;
    const [commentSubmitting, setCommentSubmitting] = useState(false);
    const commentRef = useRef<HTMLInputElement>(null);

    const createComment = (e?: { preventDefault: () => void; }) => {
        if (e) e.preventDefault();

        setCommentSubmitting(true);

        fetch(`/api/v2/feed/post/${postContent.id}/comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
            },
            body: JSON.stringify({
                content: commentRef.current?.value,
            })
        }).then(res => res.json()).then(res => {
            // just shove it in there
            setPostContent(res);
            setCommentSubmitting(false);
        });
    }

    return (
        <div className={props.className}>
            {/* "Replying to [user]" text */}
            {!props.truncate && (
                <div className="flex items-center space-x-2 mb-4">
                    <div className="flex-shrink-0">
                        <img className="h-8 w-8 rounded-full"
                             src={yipnyap_constants.currentUser.avatar || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                             alt=""/>
                    </div>
                    <div className="min-w-0 flex-1">
                        <p className="text-sm font-medium text-default cursor-pointer hover:underline">
                            Replying to your fucking ass
                        </p>
                    </div>
                </div>
            )}

            <div className={classNames(
                commentSubmitting ? 'isolate relative overflow-hidden before:absolute before:inset-0 before:border before:border-solid before:border-x-0 before:border-b-0 before:border-t before:border-neutral-100/10 before:-translate-x-full before:animate-[shimmer_2s_infinite] before:bg-gradient-to-r before:from-transparent before:via-neutral-500/5 before:to-transparent' : '',
                "relative flex items-center rounded-default"
            )}>
                <input
                    type="text"
                    name="comment"
                    id="comment"
                    className="block w-full px-10 placeholder-neutral-100 dark:placeholder-neutral-500 sm:text-sm focus:ring-primary focus:border-primary"
                    placeholder="Comment"
                    ref={commentRef}
                />
                <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <img className="h-5 w-5 rounded-full"
                         src={yipnyap_constants.currentUser.avatar || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                         alt=""/>
                </div>
                <div className="absolute items-center inset-y-0 right-0 flex py-2 pr-2 cursor-pointer">
                    {commentSubmitting ? (
                        <img className="h-5 w-5 animate-spin dark:invert"
                             src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
                             alt="Process working spinner"/>
                    ) : (
                        <PaperAirplaneIcon className="h-5 w-5 text-white" onClick={createComment} />
                    )}
                </div>
            </div>
        </div>
    )
}

function FeedListItem({...props}: any) {
    const {reply, showLine, post} = props;
    const [likes, setLikes] = useState(reply.likes || 0);
    const [postContent, setPostContent] = post;

    if (reply.id.indexOf(':') > -1) {
        reply.id = reply.id.split(':')[1]
    }

    function handleLike(id: string) {
        const newLikeCount = likes + 1;
        setLikes(newLikeCount);

        // Update it in props
        let newPostContent = postContent;
        // check if reply
        if (id.startsWith('03I4')) {
            // reply
            newPostContent.replies.forEach((reply: any) => {
                if (reply.id === id) {
                    reply.likes = newLikeCount;
                }
            });
        } else if (id.startsWith('03A1')) {
            // post
            newPostContent.likes = newLikeCount;
        }

        setPostContent(newPostContent);
    }

    return (
        <li>
            <div className="relative pb-8">
                {showLine ? (
                    <span className="absolute top-5 left-5 -ml-px h-full w-0.5 bg-neutral-300 dark:bg-neutral-700" aria-hidden="true" />
                ) : null}
                <div className="group relative flex flex-col items-start space-x-3 rounded-default cursor-pointer hover:bg-box">
                    {reply.id.startsWith('03I4') ? (
                        <>
                            <div className="relative flex flex-row items-start space-x-3">
                                <div className="relative">
                                    <NGAvatar image={reply.user.avatar} online={reply.user.online} className="bg-box-alt flex items-center justify-center rounded-full ring-8 ring-[#fafafa] dark:ring-[#2d2d2d]" />

                                    <span className="absolute -bottom-0.5 -right-1 bg-box-alt rounded-default px-0.5 py-px">
                                        {reply.likedParent && (
                                            <HandThumbUpIcon className="h-5 w-5 text-gray-400" aria-hidden="true" />
                                        )}
                                    </span>
                                </div>
                                <div className="relative min-w-0 flex-1">
                                    <div>
                                        <div className="text-sm">
                                            <a href={`/${reply.user.username}`} className="font-medium text-default">
                                                {reply.user.display_name || reply.user.username}
                                            </a>
                                        </div>
                                        <p className="text-sm text-default-alt">
                                            {reply.timestamp ? (
                                                <time
                                                    dateTime={(reply.timestamp * 1000).toString()}>
                                                    {moment(reply.timestamp * 1000).fromNow()}
                                                </time>
                                            ) : (
                                                reply.user.username
                                            )}
                                        </p>
                                    </div>

                                    <div
                                        className="mt-2 text-sm text-default break-words"
                                        style={{wordBreak: 'break-word'}} // fix for long links
                                    >
                                        {reply.content}
                                    </div>
                                </div>
                            </div>

                            {/* Settings on hover */}
                            <div className="hidden group-hover:block absolute top-0 right-0 -mr-2 -mt-2">
                                <div className="flex relative z-10 space-x-4 items-center">
                                    {/* Reply & Like */}
                                    <div className="flex flex-row items-center justify-between bg-box-alt rounded-default">
                                        <div className="flex flex-row items-center">
                                            <div
                                                className="flex flex-row items-center space-x-2 p-2 rounded-default hover:bg-box"
                                                onClick={() => handleLike(reply.id)}
                                            >
                                                <HandThumbUpIcon className="h-5 w-5 text-gray-400" aria-hidden="true" />
                                                {likes > 0 && (
                                                    <span className="text-sm text-default-alt">{likes}</span>
                                                )}
                                            </div>
                                            <div className="flex flex-row items-center space-x-2 p-2 rounded-default hover:bg-box">
                                                <ChatBubbleLeftIcon className="h-5 w-5 text-gray-400" aria-hidden="true" />
                                            </div>
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        className="flex items-center justify-center h-8 w-8 rounded-full bg-box-alt text-default hover:bg-box"
                                        aria-expanded="false"
                                        aria-haspopup="true"
                                    >
                                        <span className="sr-only">Open options</span>
                                        <EllipsisHorizontalIcon className="h-5 w-5" aria-hidden="true" />
                                    </button>
                                </div>
                            </div>
                        </>
                    ) : null}
                </div>
            </div>
        </li>
    )
}

// Goes through replies, and calls itself again with padding if there are replies within replies.
function RecursiveCommentThread({...props}: any) {
    const {reply, showLine, post} = props;

    return (
        <>
            <FeedListItem reply={reply} showLine={showLine || false} post={post} />
            {reply.replies && reply.replies.length > 0 && reply.replies.map((replyInside: any, replyInsideIdx: any) => (
                <>
                    <div className="pl-12">
                        <RecursiveCommentThread key={replyInsideIdx} reply={replyInside} showLine={replyInsideIdx !== reply.replies.length - 1} post={post} />
                    </div>
                </>
            ))}
        </>
    )
}

function MediaGrid({...props}: any) {
    const {post, objects, truncate} = props;
    const [, setSelectedMedia] = props.selectState;
    const [grabbing, isGrabbing] = useState(false);
    const [isBear, setIsBear] = useState(false);

    // IMPORTANT!
    /*
     *      (()__(()
     *      /       \
     *     ( /    \  \
     *      \ o o    /
     *      (_()_)__/ \
     *     / _,==.____ \
     *    (   |--|      )
     *    /\_.|__|'-.__/\_
     *   / (        /     \
     *   \  \      (      /
     *    )  '._____)    /
     * (((____.--(((____/mrf
     *
     * sincerely,
     * the bear
     */
    useEffect(() => {
        const handleShift = (e: any) => {
            if (e.type === 'keydown' && e.key === 'Shift') {
                setIsBear(post?.user.username.toLowerCase().includes('bear') || post?.user.username.toLowerCase().includes('beaw') || post?.user.username.toLowerCase().includes('burr'));
            }
        }

        const handleShiftCancel = (e: any) => {
            if (e.type === 'keyup' && e.key === 'Shift') {
                setIsBear(false);
            }
        }

        const handleMouseDown = () => {
            if (isBear) {
                console.log('bear');
                isGrabbing(true);
            }
        }

        const handleMouseUp = () => {
            if (isBear) {
                console.log('bearn\'t');
                isGrabbing(false);
            }
        }

        document.addEventListener('mouseup', handleMouseUp);
        document.addEventListener('mousedown', handleMouseDown);
        document.addEventListener('keydown', handleShift);
        document.addEventListener('keyup', handleShiftCancel);
        return () => {
            document.removeEventListener('mouseup', handleMouseUp);
            document.removeEventListener('mousedown', handleMouseDown);
            document.removeEventListener('keydown', handleShift);
            document.removeEventListener('keyup', handleShiftCancel);
        }
    }, [objects, isBear]);

    const handleClick = () => {
        if (!isBear) {
            setSelectedMedia(objects[0]);
        }
    }

    return (
        <div className="mt-4">
            <div className={objects.length > 1 ? 'flex flex-col' : ''}>
                <div className="aspect-w-10 aspect-h-7 block w-full overflow-hidden rounded-default">
                    {/* @todo: CLEANNNN */}
                    {objects[0].id.split(':')[1].substring(2, 4) === 'C1' && (
                        <img
                            src={objects[0].url}
                            alt=""
                            className={`aspect-w-10 aspect-h-7 w-full object-cover ${isBear ? (grabbing ? 'cursor-grabbing' : 'cursor-grab') : 'cursor-pointer'}`}
                            onClick={handleClick}
                        />
                    )}

                    {objects[0].id.split(':')[1].substring(2, 4) === 'C2' && (
                        <video
                            src={objects[0].url}
                            className="aspect-w-10 aspect-h-7 object-cover"
                            controls
                        />
                    )}
                </div>

                {objects.length >= 2 && (
                    <div className={`mt-2 grid ${objects.length >= 2 ? 'grid-cols-3' : ''} gap-2`}>
                        {objects.slice(1).map((object: { url: string | undefined; id: string; }, objectIndex: number) => {
                            if (truncate && objectIndex === 2) return (
                                <div key={objectIndex} className="w-full overflow-hidden rounded-default">
                                    <div className="relative aspect-square">
                                        <img
                                            src={object.url}
                                            alt=""
                                            className="aspect-square object-cover w-full h-full"
                                            onClick={/* @ts-ignore */
                                                () => setSelectedMedia(object)}
                                        />

                                        {/* @ts-ignore - postContent.objects is very obviously defined :| */}
                                        {objects.length > 4 && (
                                            <div className="absolute mt-2 mr-2 top-0 right-0 flex items-center justify-center">
                                                <div className="bg-box rounded-default p-2">
                                                    {/* @ts-ignore - for fuck sake. */}
                                                    <span className="text-defualt-alt text-sm">+{objects.length - 4}</span>
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            )

                            if (truncate && objectIndex >= 3) return null;
                            // Check E2 for object variant
                            switch (object.id.split(':')[1].substring(2, 4)) {
                                case 'C1':
                                    return (
                                        <div key={objectIndex} className={`aspect-square w-full overflow-hidden rounded-default`}>
                                            <img
                                                src={object.url}
                                                alt=""
                                                className="aspect-square object-cover w-full h-full"
                                                onClick={/* @ts-ignore */
                                                    () => setSelectedMedia(object)}
                                            />
                                        </div>
                                    )
                            }
                        })}
                    </div>
                )}
            </div>
        </div>
    )
}
