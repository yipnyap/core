import React, {Fragment} from 'react';
import moment from 'moment';
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
import {Menu, Transition} from "@headlessui/react";
import {
    ChatBubbleBottomCenterTextIcon,
    EllipsisHorizontalIcon,
    FlagIcon,
    HandThumbUpIcon, ShareIcon,
    StarIcon
} from "@heroicons/react/24/solid";
import {NGCard} from "../NGCard";
import {NavLink} from "react-router-dom";

export declare interface NGFeedPostDataType {
    _id: string;
    likes?: string;
    user: {
        imageUrl?: string;
        username: string;
        displayName?: string;
    };
    timestamp: number;
    body: JSX.Element;
    replies?: NGFeedPostDataType[];
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
    let theme = buildClassObject(NGFeedPostTheming, props.theme || undefined)

    return (
        <NGCard title={
            <>
                <div>
                    <div className="flex space-x-3">
                        <div className="flex-shrink-0">
                            <img className="h-10 w-10 rounded-full"
                                 src={props.post.user.imageUrl || `${yipnyap_constants.yipnyap_url}/img/avatar/default-avatar.png`} alt=""/>
                        </div>
                        <div className="min-w-0 flex-1">
                            <p className="text-sm font-medium text-neutral-900 dark:text-white cursor-pointer hover:underline">
                                <NavLink to={`/@${props.post.user.username}`}>
                                    {props.post.user.displayName}
                                </NavLink>
                            </p>
                            <p className="text-sm text-neutral-500 cursor-pointer hover:underline">
                                <NavLink to={`/@!${props.post._id}`}>
                                    <time dateTime={props.post.timestamp.toString()}>{moment(props.post.timestamp).fromNow()}</time>
                                </NavLink>
                            </p>
                        </div>
                        <div className="flex-shrink-0 self-center flex">
                            <Menu as="div" className="relative inline-block text-left">
                                <div>
                                    <Menu.Button
                                        className="-m-2 p-2 rounded-full flex items-center text-neutral-400 hover:text-neutral-600">
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
                                                        className={classNames(
                                                            active ? 'bg-gray-100 text-neutral-900' : 'text-neutral-700',
                                                            'flex px-4 py-2 text-sm'
                                                        )}
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
                                                        className={classNames(
                                                            active ? 'bg-gray-100 text-neutral-900' : 'text-neutral-700',
                                                            'flex px-4 py-2 text-sm'
                                                        )}
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
                </div>
                <div
                    className="mt-2 text-sm text-neutral-700 space-y-4 dark:text-neutral-50">
                    {props.post.body}
                </div>
                <div className="mt-6 flex justify-between space-x-8">
                    <div className="flex space-x-6">
                                                    <span className="inline-flex items-center text-sm">
                                                        <button type="button" className="inline-flex space-x-2 text-neutral-400 hover:text-neutral-500">
                                                            <HandThumbUpIcon className="h-5 w-5" aria-hidden="true"/>
                                                            <span className="font-medium text-neutral-900 dark:text-neutral-400">{props.post.likes}</span>
                                                            <span className="sr-only">likes</span>
                                                        </button>
                                                    </span>
                        <span className="inline-flex items-center text-sm">
                                                        <button type="button" className="inline-flex space-x-2 text-neutral-400 hover:text-neutral-500">
                                                            <ChatBubbleBottomCenterTextIcon className="h-5 w-5" aria-hidden="true"/>
                                                            <span className="font-medium text-neutral-900 dark:text-neutral-400">{props.post.replies?.length || 0}</span>
                                                            <span className="sr-only">replies</span>
                                                        </button>
                                                    </span>
                    </div>
                    <div className="flex text-sm">
                                                    <span className="inline-flex items-center text-sm">
                                                        <button type="button" className="inline-flex space-x-2 text-neutral-400 hover:text-neutral-500">
                                                            <ShareIcon className="h-5 w-5" aria-hidden="true"/>
                                                            <span className="font-medium text-neutral-900 dark:text-neutral-400">Share</span>
                                                        </button>
                                                    </span>
                    </div>
                </div>
            </>}
                // wellBody
        >
            {props.post.replies && (
                <div>
                    <div className="flex">
                        <div className="mr-4 flex-shrink-0">
                            <img className="h-10 w-10 rounded-full"
                                 src={props.post.replies[0].user.imageUrl} alt=""/>
                        </div>
                        <div>
                            <div className="min-w-0 flex-1">
                                <p className="text-sm font-medium text-neutral-900 dark:text-white">
                                    <a href={`/@${props.post.replies[0].user.username}`} className="hover:underline">
                                        {props.post.replies[0].user.displayName}
                                    </a>
                                </p>
                                <p className="text-sm text-neutral-500">
                                    <a href={`/@!${props.post.replies[0]._id}`} className="hover:underline">
                                        <time dateTime={props.post.replies[0].timestamp.toString()}>{props.post.replies[0].timestamp}</time>
                                    </a>
                                </p>
                            </div>
                            <p className="mt-2 text-sm text-neutral-700 space-y-4 dark:text-neutral-50">
                                {props.post.replies[0].body}
                            </p>
                        </div>
                    </div>
                </div>
            )}
        </NGCard>
    );
}
