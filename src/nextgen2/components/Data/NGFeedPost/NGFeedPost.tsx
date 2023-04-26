import React, {Fragment} from 'react';
import moment from 'moment';
import {Menu, Transition} from '@headlessui/react';
import {
    ChatBubbleBottomCenterTextIcon, EllipsisHorizontalIcon, FlagIcon, HandThumbUpIcon, StarIcon,
} from '@heroicons/react/24/solid';
import {NGCard} from '../../Layout/NGCard';
import {ChatBubbleLeftIcon, PaperAirplaneIcon} from "@heroicons/react/20/solid";

export declare interface NGFeedPostDataType {
    id: string;
    likes?: number;
    user: {
        imageUrl?: string; username: string; displayName?: string;
    };
    timestamp: number;
    replies?: NGFeedPostDataType[];
    children?: React.ReactNode; // for comments
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
    // @ts-ignore
    return (
        <NGCard noPadding>
            <div className="relative">
                <div className="px-4 py-5 sm:px-6">
                    <div className="flex space-x-3">
                        <div className="flex-shrink-0">
                            <img className="h-10 w-10 rounded-full"
                                 src={props.post.user.imageUrl || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                                 alt=""/>
                        </div>
                        <div className="min-w-0 flex-1 flex flex-col justify-center">
                            <a href={`/@${props.post.user.username}`} className="font-medium text-default cursor-pointer hover:underline">
                                {props.post.user.displayName || props.post.user.username}
                            </a>
                            <a href={`/@!${props.post.id}`} className="text-sm text-default-alt cursor-pointer hover:underline">
                                <time
                                    dateTime={props.post.timestamp.toString()}>
                                    {moment(props.post.timestamp).fromNow()}
                                </time>
                            </a>
                        </div>
                        <div className="flex-shrink-0 self-center flex">
                            <Menu as="div" className="relative inline-block text-left">
                                <div>
                                    <Menu.Button
                                        className="-m-2 p-2 rounded-full text-neutral-400 hover:text-neutral-600">
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
                    {/*<h2 id={'question-title-' + question.id} className="mt-4 text-base font-medium text-neutral-900">*/}
                    {/*    {question.title}*/}
                    {/*</h2>*/}
                    <div
                        className="mb-6 mt-4 text-sm text-neutral-700 space-y-4 dark:text-neutral-50">
                        {props.children}
                    </div>
                </div>

                {/* Floating "User is typing..." card */}
                <div className="absolute bottom-0 left-0 ml-4 sm:ml-6 bg-box-alt border-x border-t border-b-0 border-solid border-neutral-300 dark:border-neutral-700 rounded-tl-xl rounded-tr-xl">
                    <div className="flex items-center space-x-2 px-4 py-2">
                        <div className="flex-shrink-0">
                            <img className="h-4 w-4 rounded-full"
                                    src={props.post.user.imageUrl || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                                    alt=""/>
                        </div>
                        <div className="min-w-0 flex-1">
                            <p className="text-sm font-medium text-default cursor-pointer hover:underline">
                                {props.post.user.username} is typing...
                            </p>
                        </div>
                    </div>
                </div>
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
                        <span className="ml-2">Like</span>
                    </span>
                    <span
                        className="inline-flex items-center text-sm cursor-pointer hover:underline"
                        onClick={() => {
                            console.log('like')
                        }}
                        >
                        <ChatBubbleBottomCenterTextIcon className="h-5 w-5 text-neutral-400" />
                    </span>
                </div>

                {/* Textbox */}
                <div className="flex-1 relative flex items-center rounded-default">
                    <input
                        type="text"
                        name="comment"
                        id="comment"
                        className="block w-full pr-12 placeholder-neutral-100 dark:placeholder-neutral-500 sm:text-sm focus:ring-primary focus:border-primary"
                        placeholder="Comment"
                    />
                    <div className="absolute items-center inset-y-0 right-0 flex py-2 pr-2 cursor-pointer">
                        <PaperAirplaneIcon className="h-5 w-5 text-white" />
                    </div>
                </div>
            </div>

            {/* Replies */}
            {props.post?.replies && props.post.replies.length > 0 && (
                <div className="px-4 py-4 sm:px-6 bg-box-alt">
                    <div className="flow-root">
                        <ul role="list" className="-mb-8">
                            {props.post.replies.map((reply, idx) => (
                                <>
                                    {/* @ts-ignore - props.post.replies isn't fucking undefined. */}
                                    <FeedListItem key={reply.id} reply={reply} showLine={idx !== props.post.replies.length - 1} />
                                    {reply.replies && reply.replies.length > 0 && reply.replies.map((replyInside, replyInsideIdx) => (
                                        <>
                                            {/* @ts-ignore - fuck sake. */}
                                            <FeedListItem key={replyInside.id} reply={replyInside} showLine={replyInsideIdx !== reply.replies.length - 1} />
                                        </>
                                    ))}
                                </>
                            ))}
                        </ul>
                    </div>
                </div>
            )}
        </NGCard>
    );
}

function FeedListItem({...props}: any) {
    const {reply, showLine} = props;

    return (
        <li>
            <div className="relative pb-8">
                {showLine ? (
                    <span className="absolute top-5 left-5 -ml-px h-full w-0.5 bg-neutral-300 dark:bg-neutral-700" aria-hidden="true" />
                ) : null}
                <div className="relative flex items-start space-x-3">
                    {reply.id.startsWith('03I4') ? (
                        <>
                            <div className="relative">
                                <img
                                    className="h-10 w-10 rounded-full bg-box-alt flex items-center justify-center ring-8 ring-[#fafafa] dark:ring-[#2d2d2d]"
                                    src={reply.user.imageUrl || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`}
                                    alt=""
                                />

                                <span className="absolute -bottom-0.5 -right-1 bg-box-alt rounded-tl px-0.5 py-px">
                                                                <ChatBubbleLeftIcon className="h-5 w-5 text-gray-400" aria-hidden="true" />
                                                            </span>
                            </div>
                            <div className="min-w-0 flex-1">
                                <div>
                                    <div className="text-sm">
                                        <a href={`/@${reply.user.username}`} className="font-medium text-default">
                                            {reply.user.username}
                                        </a>
                                    </div>
                                    <p className="text-sm text-default-alt">{moment(reply.timestamp).fromNow()}</p>
                                </div>
                                <div className="mt-2 text-sm text-gray-700">
                                    {reply.children}
                                </div>
                            </div>
                        </>
                    ) : null}
                </div>
            </div>
        </li>
    )
}
