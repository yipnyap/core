import React, {Fragment} from 'react';
import {buildClassObject} from "../../utils/ColourScheme.utils";
import {ChevronDownIcon, EnvelopeIcon, UserPlusIcon} from "@heroicons/react/24/solid";
import {Menu, Transition} from "@headlessui/react";

export declare interface NGProfileHeaderType {
    user: any;
    self?: boolean;
    loggedIn?: boolean;
    defaults?: {
        header?: string;
        profile?: string;
    }

    theme?: any;
    children?: React.ReactNode;
}

export const NGProfileHeaderTheming = {
    main: [],
    button: ['w-full', 'inline-flex', 'justify-center', 'py-2', 'px-4', 'border', 'border-neutral-300 dark:border-neutral-500',
        'rounded-lg', 'shadow-sm', 'bg-default', 'text-sm', 'font-medium', 'text-default',
        'hover:bg-neutral-50 dark:hover:bg-neutral-700']
}

const items = [
    {
        name: 'Send Friend Request',
        description: 'Being friend\'s with a user will still count a follow.',
        href: '#'
    },
    /* "There is a genuine danger to it too. Stalkers. You can't block a stalker when you don't know their account."
     * -Tap
     *
     * "That being said It will happen regardless of if it's not there"
     * -^
     *
     * Original Description:
     * "They will be unable to see that you follow them, but you will still affect their count."
     */
    {
        name: 'Follow silently',
        description: 'They will still see that you follow them, but no one else can. Yipnyap can still see who you follow.',
        href: '#'
    },
    {
        name: 'Block',
        href: '#'
    },
]

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

function NGFollowButton({...props}: any) {
    return (
        <span className="relative inline-flex shadow-sm rounded-lg">
      <button
          type="button"
          className={`${props.theme.button} relative items-center rounded-none rounded-l-md`}
      >
          <UserPlusIcon className="-ml-1 mr-2 h-5 w-5 text-neutral-400 dark:text-white" aria-hidden="true" />
          Follow
      </button>
      <Menu as="span" className="-ml-px relative block">
        <Menu.Button className={`${props.theme.button} relative rounded-none px-2 rounded-r-md`}>
          <span className="sr-only">Open options</span>
          <ChevronDownIcon className="h-5 w-5" aria-hidden="true" />
        </Menu.Button>
        <Transition
            as={Fragment}
            enter="transition ease-out duration-100"
            enterFrom="transform opacity-0 scale-95"
            enterTo="transform opacity-100 scale-100"
            leave="transition ease-in duration-75"
            leaveFrom="transform opacity-100 scale-100"
            leaveTo="transform opacity-0 scale-95"
        >
          <Menu.Items className="origin-top-right absolute right-0 mt-2 -mr-1 w-56 rounded-lg shadow-lg bg-default ring-1 ring-black ring-opacity-5 focus:outline-none">
            <div className="py-1">
              {items.map((item) => (
                  <Menu.Item key={item.name}>
                      {({ active }) => (
                          <a
                              href={item.href}
                              className={classNames(
                                  active ? 'bg-default-alt text-default-alt' : 'text-default',
                                  'block px-4 py-2 text-sm'
                              )}
                          >
                              {item.name}
                              {item.description && (
                                  <span className="block text-xs text-gray-400">{item.description}</span>
                              )}
                          </a>
                      )}
                  </Menu.Item>
              ))}
            </div>
          </Menu.Items>
        </Transition>
      </Menu>
    </span>
    )
}

export default function NGProfileHeader({...props}: NGProfileHeaderType) {
    let theme = buildClassObject(NGProfileHeaderTheming, props.theme || undefined);
    const profile = props.user;

    return (
        <div className="relative z-10 pb-8 rounded-lg bg-default">
            <div>
                <img className="h-32 w-full object-cover lg:h-60" src={profile.pictures?.header?.url || props.defaults?.header || '/img/default-cover.png'} alt="Profile cover" />
            </div>
            <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                    <div className="flex">
                        <img className="bg-default h-24 w-24 rounded-full ring-4 ring-white dark:ring-neutral-800 sm:h-32 sm:w-32" src={profile.avatar || props.defaults?.profile || '/img/default-avatar.png'} alt="" />
                    </div>
                    <div className="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                        <div className="sm:hidden md:block mt-6 min-w-0 flex-1">
                            <h1 className="text-2xl font-bold text-default truncate">{profile.username}</h1>
                        </div>
                        {props.loggedIn && !props.self && (
                            <div className="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                                <button
                                    type="button"
                                    className={`${theme.button}`}
                                >
                                    <EnvelopeIcon className="-ml-1 mr-2 h-5 w-5 text-neutral-400 dark:text-white" aria-hidden="true" />
                                    <span>Message</span>
                                </button>
                                <NGFollowButton theme={theme} />
                            </div>
                        )}
                    </div>
                </div>
                <div className="hidden sm:block md:hidden mt-6 min-w-0 flex-1">
                    <h1 className="text-2xl font-bold text-gray-900 truncate">{profile.username}</h1>
                </div>
            </div>
        </div>
    );
}
