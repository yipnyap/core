// @todo: maybe OpenAI this?

import {useHeading} from '@nextgen2/providers/PageHeading.provider';
import React, {Fragment, useEffect, useState} from 'react'
import {Combobox, Dialog, Transition} from '@headlessui/react'
import {MagnifyingGlassIcon} from '@heroicons/react/20/solid'
import {
    BellIcon, ExclamationCircleIcon, QuestionMarkCircleIcon, PaintBrushIcon, ShareIcon, ShieldCheckIcon, UserIcon,
} from '@heroicons/react/24/outline'
import {useNavigate} from 'react-router-dom';

const settings = [{
    id: 1,
    name: 'Account',
    description: 'Manage your account settings',
    tags: `email password profile avatar picture username nickname handle name surname family name given name first name last name display name bio description about location`,
    icon: QuestionMarkCircleIcon,
    href: '/settings/',
}, {
    id: 2,
    name: 'Appearance',
    description: 'Customize your account & UI appearance',
    tags: 'theme color light dark mode theme',
    icon: PaintBrushIcon,
    href: '/settings/skin/',
}, {
    id: 3,
    name: 'Social accounts',
    description: 'Boast your social media presence',
    tags: `twitter facebook instagram reddit youtube twitch github linkedin discord telegram tiktok`,
    icon: ShareIcon,
    href: '/settings/social/',
}, {
    id: 4,
    name: 'Notifications',
    description: 'Manage your mobile notifications',
    icon: BellIcon,
    href: '/settings/telegram/',
}, {
    id: 5,
    name: 'Security',
    description: 'Configure two-factor authentication, telegram, and reset your password',
    tags: `2fa two-factor authentication telegram password reset change update forgot lost recover`,
    icon: ShieldCheckIcon,
    href: '/settings/telegram/',
}, {
    id: 6,
    name: 'Profile bio',
    description: 'Add a bio to your profile',
    tags: `bio description about location`,
    icon: QuestionMarkCircleIcon,
    href: '/settings/',
}, {
    id: 7,
    name: 'Display Name',
    description: 'Change your display name',
    tags: 'username nickname handle',
    icon: UserIcon,
    href: '/settings/',
}]

function classNames(...classes: (string | boolean)[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGCommandPalette({...props}: {
    states: [boolean, React.Dispatch<React.SetStateAction<boolean>>]
    friends: any[]
    groups: any[]
    pages: any[]
}) {
    const [heading] = useHeading()
    const navigate = useNavigate()
    const [open, setOpen] = props.states
    const [rawQuery, setRawQuery] = useState('')
    const [users, setUsers] = useState(props.friends)
    const [groups, setGroups] = useState(props.groups)

    const query = rawQuery.toLowerCase().replace(/^[#@~]/, '')

    const filteredGroups = rawQuery === '#' ? groups : query === '' || rawQuery.startsWith('@') ? [] : groups.filter((group) => group.name.toLowerCase().includes(query) || group.description.toLowerCase().includes(query) || group.tags?.toLowerCase().split(', ').some((tag: string) => query.includes(tag)))

    const filteredUsers = rawQuery === '@' ? users : query === '' || rawQuery.startsWith('#') ? [] : users.filter((user) => user.username.toLowerCase().includes(query) || user.display_name.toLowerCase().includes(query) || user.bio?.toLowerCase().includes(query))

    // Match settings by name, description, or tags regardless of order
    const filteredSettings = rawQuery === '~' ? settings : query === '' || rawQuery.startsWith('~') ? [] : settings.filter((setting) => setting.name.toLowerCase().includes(query) || setting.description.toLowerCase().includes(query) || setting.tags?.toLowerCase().split(' ').some((tag) => query.includes(tag)) || setting.tags?.toLowerCase().includes(query))

    let pages = [...(
        heading?.navigator?.subNavigation || []
    ), ...props.pages]
    pages = pages.filter((page) => typeof page.icon !== 'string' && typeof page.name === 'string')
    // remove duplicates
    pages = pages.filter((page, index) => pages.findIndex((p) => p.name === page.name) === index)

    const filteredPages = rawQuery === '!' ? pages : query === '' || rawQuery.startsWith('!') ? [] : pages.filter((page: any) => page.name.toLowerCase().includes(query))

    // Poll `yipnyap_constants`
    // Needs to be removed once UI is split.
    if (yipnyap_constants?.currentUser?.groups) {
        if (yipnyap_constants.currentUser.groups.length !== groups.length) setGroups(yipnyap_constants.currentUser.groups)
    }

    useEffect(() => {
        setUsers(props.friends)
    }, [props.friends])

    const keydownHandler = (e: KeyboardEvent) => {
        if (e.ctrlKey && e.key === 'k') {
            e.preventDefault()
            setOpen(true)
        }
    };

    useEffect(() => {
        document.addEventListener('keydown', keydownHandler);

        return () => {
            document.removeEventListener('keydown', keydownHandler);
        }
    }, []);

    return (
        <Transition.Root show={open} as={Fragment} afterLeave={() => setRawQuery('')}>
            <Dialog as="div" className="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20" onClose={setOpen}>
                <Transition.Child
                    as={Fragment}
                    enter="ease-out duration-300"
                    enterFrom="opacity-0"
                    enterTo="opacity-100"
                    leave="ease-in duration-200"
                    leaveFrom="opacity-100"
                    leaveTo="opacity-0"
                >
                    <Dialog.Overlay
                        className="fixed inset-0 bg-neutral-500/25 bg-opacity-75 backdrop-blur transition-opacity"/>
                </Transition.Child>

                <Transition.Child
                    as={Fragment}
                    enter="ease-out duration-300"
                    enterFrom="opacity-0 translate-y-4 rotate-1"
                    enterTo="opacity-100 translate-y-0 rotate-0"
                    leave="ease-in duration-200"
                    leaveFrom="opacity-100 translate-y-0 rotate-0 sm:scale-100"
                    leaveTo="opacity-0 translate-y-4 -rotate-1 sm:translate-y-0 sm:scale-95"
                >
                    <Combobox
                        as="div"
                        className="mx-auto max-w-xl transform divide-y divide-neutral-100 overflow-hidden rounded-xl bg-box shadow-2xl ring-1 ring-black ring-opacity-5 transition-all"
                        onChange={(item: any) => {
                            if (item.member_count) {
                                navigate(`/groups/${item.id}/`)
                            } else if (item.username) {
                                navigate(`/${item.username}/`)
                            } else {
                                navigate(item.href)
                            }

                            setOpen(false)
                        }}
                    >
                        <div className="relative">
                            <MagnifyingGlassIcon
                                className="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-neutral-400"
                                aria-hidden="true"
                            />
                            <Combobox.Input
                                className="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-neutral-800 placeholder-neutral-400 focus:ring-0 sm:text-sm"
                                placeholder="Search..."
                                onChange={(event) => setRawQuery(event.target.value)}
                            />
                        </div>

                        {(
                            filteredGroups.length > 0 || filteredUsers.length > 0 || filteredSettings.length > 0 || filteredPages.length > 0
                        ) && (
                            <Combobox.Options
                                static
                                className="max-h-80 scroll-py-10 scroll-pb-2 space-y-4 overflow-y-auto p-4 pb-2"
                            >
                                {filteredGroups.length > 0 && (
                                    <li>
                                        <h2 className="text-xs font-semibold text-default">Groups</h2>
                                        <ul className="-mx-4 mt-2 text-sm text-default-alt">
                                            {filteredGroups.map((group) => (
                                                <Combobox.Option
                                                    key={group.id}
                                                    value={group}
                                                    className={({active}) => classNames('flex cursor-default select-none items-center px-4 py-2', active && 'bg-indigo-600 text-white')}
                                                >
                                                    <img src={group.avatar} alt=""
                                                         className="h-6 w-6 flex-none rounded-full"/>
                                                    <span className="ml-3 flex-auto truncate">{group.name}</span>
                                                </Combobox.Option>
                                            ))}
                                        </ul>
                                    </li>
                                )}
                                {filteredUsers.length > 0 && (
                                    <li>
                                        <h2 className="text-xs font-semibold text-default">Users</h2>
                                        <ul className="-mx-4 mt-2 text-sm text-default-alt">
                                            {filteredUsers.map((user) => (
                                                <Combobox.Option
                                                    key={user.id}
                                                    value={user}
                                                    className={({active}) => classNames('flex cursor-default select-none items-center px-4 py-2', active && 'bg-indigo-600 text-white')}
                                                >
                                                    <img src={user.avatar} alt=""
                                                         className="h-6 w-6 flex-none rounded-full"/>
                                                    <span className="ml-3 flex-auto truncate">{user.username}</span>
                                                </Combobox.Option>
                                            ))}
                                        </ul>
                                    </li>
                                )}
                                {filteredPages.length > 0 && (
                                    <li>
                                        <h2 className="text-xs font-semibold text-default">Pages</h2>
                                        <ul className="-mx-4 mt-2 text-sm text-default-alt">
                                            {filteredPages.map((page, i) => (
                                                <Combobox.Option
                                                    key={i}
                                                    value={page}
                                                    className={({active}) => classNames('flex cursor-default select-none items-center px-4 py-2', active && 'bg-indigo-600 text-white')}
                                                >
                                                    {({active}) => (
                                                        <>
                                                            <page.icon
                                                                className={classNames('h-6 w-6 flex-none', active ? 'text-default' : 'text-default-alt')}
                                                                aria-hidden="true"
                                                            />
                                                            <span
                                                                className="ml-3 flex-auto truncate">{page.name}</span>
                                                        </>
                                                    )}
                                                </Combobox.Option>
                                            ))}
                                        </ul>
                                    </li>
                                )}
                                {filteredSettings.length > 0 && (
                                    <li>
                                        <h2 className="text-xs font-semibold text-default">Settings</h2>
                                        <ul className="-mx-4 mt-2 text-sm text-default-alt">
                                            {filteredSettings.map((setting) => (
                                                <Combobox.Option
                                                    key={setting.id}
                                                    value={setting}
                                                    className={({active}) => classNames('flex cursor-default select-none items-center px-4 py-2', active && 'bg-indigo-600 text-white')}
                                                >
                                                    {({active}) => (
                                                        <>
                                                            <setting.icon
                                                                className={classNames('h-6 w-6 flex-none', active ? 'text-default' : 'text-default-alt')}
                                                                aria-hidden="true"
                                                            />
                                                            <span
                                                                className="ml-3 flex-auto truncate">{setting.name}</span>
                                                        </>
                                                    )}
                                                </Combobox.Option>
                                            ))}
                                        </ul>
                                    </li>
                                )}
                            </Combobox.Options>
                        )}

                        {rawQuery === '?' && (
                            <div className="py-14 px-6 text-center text-sm sm:px-14">
                                <QuestionMarkCircleIcon className="mx-auto h-6 w-6 text-default-alt"
                                                        aria-hidden="true"/>
                                <p className="mt-4 font-semibold text-default">Help with searching</p>
                                <p className="mt-2 text-default-alt">
                                    Use this tool to quickly search for users and projects across our entire platform.
                                    You can also use
                                    the search modifiers found in the footer below to limit the results to just users or
                                    projects. To search explicitly for settings, use <code>~</code>.
                                </p>
                            </div>
                        )}

                        {query !== '' && rawQuery !== '?' && rawQuery !== '🐈' && filteredGroups.length === 0 && filteredUsers.length === 0 && filteredSettings.length === 0 && filteredPages.length === 0 && (
                            <div className="py-14 px-6 text-center text-sm sm:px-14">
                                <ExclamationCircleIcon className="mx-auto h-6 w-6 text-default-alt" aria-hidden="true"/>
                                <p className="mt-4 font-semibold text-default">No results found</p>
                                <p className="mt-2 text-default-alt">
                                    We couldn’t find anything with that term. Please try again.
                                </p>
                            </div>
                        )}

                        {/* Cat shaking easter egg */}
                        {rawQuery === '🐈' && (
                            <div className="py-14 px-6 text-center text-sm sm:px-14">
                                <div className="mx-auto w-auto text-default-alt snapanim-shake">
                                    <img
                                        src={`${yipnyap_constants.yipnyap_url}/img/illustrations/onboarding/gray-cat.png`}
                                        alt=""/>
                                </div>
                            </div>
                        )}

                        <div className="flex flex-wrap items-center bg-box-solid py-2.5 px-4 text-xs text-default">
                            Type{' '}
                            <kbd
                                className={classNames(`mx-1 flex h-5 w-5 items-center justify-center rounded border bg-box-alt font-semibold sm:mx-2`, rawQuery.startsWith('#') ? 'border-indigo-600 text-indigo-600' : 'border-neutral-400 text-neutral-500')}
                            >
                                #
                            </kbd>{' '}
                            <span className="sm:hidden">for groups,</span>
                            <span className="hidden sm:inline">to access groups,</span>
                            <kbd
                                className={classNames(`mx-1 flex h-5 w-5 items-center justify-center rounded border bg-box-alt font-semibold sm:mx-2`, rawQuery.startsWith('@') ? 'border-indigo-600 text-indigo-600' : 'border-neutral-400 text-neutral-500')}
                            >
                                @
                            </kbd>{' '}
                            for users, or{' '}
                            <kbd
                                className={classNames(`mx-1 flex h-5 w-5 items-center justify-center rounded border bg-box-alt font-semibold sm:mx-2`, rawQuery === '?' ? 'border-indigo-600 text-indigo-600' : 'border-neutral-400 text-neutral-500')}
                            >
                                ?
                            </kbd>{' '}
                            for more.
                        </div>
                    </Combobox>
                </Transition.Child>
            </Dialog>
        </Transition.Root>
    )
}
