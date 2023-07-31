import React, {useEffect, useRef, useState} from 'react';
import {
    ChatBubbleLeftIcon,
    CheckCircleIcon,
    CheckIcon,
    ChevronDoubleDownIcon,
    ChevronUpDownIcon
} from '@heroicons/react/24/outline'
import {PhotoIcon, UserCircleIcon} from "@heroicons/react/24/solid";
import {NGAvatar, NGButton, NGHeading, NGProfileHeader, NGSwitch} from "@nextgen2/components";
import {ArrowLeftIcon, ArrowRightIcon, ArrowUpRightIcon, ChevronDownIcon} from "@heroicons/react/20/solid";
import SettingsAccessibility from "@nextgen2/pages/settings/accessibility";
import SettingsSkin from "@nextgen2/pages/settings/skin";

const secondaryNavigation = [
    { name: 'Overview', href: '#', current: true },
    { name: 'Activity', href: '#', current: false },
    { name: 'Friends', href: '#', current: false },
    { name: 'Notifications', href: '#', current: false },
]

function classNames(...classes: string[]) {
    return classes.filter(Boolean).join(' ')
}

export default function Home() {
    return (
        <main className="pb-32">
            <header className="top-0 sticky z-20 dark:bg-neutral-900/70 backdrop-blur-lg">
                {/* Secondary navigation */}
                <nav className="flex overflow-x-auto border-0 border-b border-solid border-default py-4">
                    <ul
                        role="list"
                        className="flex min-w-full flex-none gap-x-6 px-4 text-sm font-semibold leading-6 text-default-alt sm:px-6 lg:px-8"
                    >
                        {secondaryNavigation.map((item) => (
                            <li key={item.name}>
                                <a href={item.href} className={item.current ? 'text-primary' : 'text-default-alt'}>
                                    {item.name}
                                </a>
                            </li>
                        ))}
                    </ul>
                </nav>
            </header>

            {/* Heading */}
            <div className="flex flex-col items-start justify-between gap-x-8 gap-y-4 bg-box bg-white dark:bg-neutral-700/10 px-4 py-4 sm:flex-row sm:items-center sm:px-6 lg:px-8">
                <div>
                    <div className="flex items-center gap-x-3">
                        <div className="flex-none rounded-full bg-green-400/10 p-1 text-green-400">
                            <div className="h-2 w-2 rounded-full bg-current" />
                        </div>
                        <h1 className="flex gap-x-3 text-base leading-7">
                            <span className="font-semibold text-default">@{yipnyap_constants.currentUser.username}</span>
                            <span className="text-default-alt">/</span>
                            <span className="font-semibold text-default">yipnyap.me</span>
                        </h1>
                    </div>
                    <p className="mt-2 text-xs leading-6 text-neutral-400">
                        <span className="font-semibold text-default">yipnyap.me</span> is a part of{' '}
                        the galactiverse - the fediverse + open non-activitypub protocols.
                    </p>
                </div>
            </div>

            {!yipnyap_constants.currentUser.dipswitch?.NeedsUI3Onboarding && (
                <NewUserOnboarding />
            )}

            {/* Activity list */}
            <div className="border-0 border-t border-solid border-default pt-11">
                <h2 className="px-4 text-base font-semibold leading-7 text-default sm:px-6 lg:px-8">Latest activity</h2>
                <div className="mt-6 w-full whitespace-nowrap text-left">
                    <LatestActivityList />
                </div>
            </div>
        </main>
    );
}

export function LatestActivityList() {
    return (
    //     all caught up
        <div className="flex flex-col items-center justify-center">
            <CheckCircleIcon className="h-12 w-12 text-green-500" aria-hidden="true" />
            <h3 className="mt-4 text-sm font-medium leading-6 text-default">You're all caught up!</h3>
            <p className="text-sm leading-5 text-default-alt">
                You have no new notifications.
            </p>
        </div>
    )
}

export function NewUserOnboarding() {
    const currentStep = yipnyap_constants.currentUser?.dipswitch?.NewUserOnboardingStep || 0;
    const steps = [
        {
            id: '01',
            name: 'Who you are',
            description: 'Set your @handle, nickname, avatar, etc.',
            href: '#',
            current: currentStep === 0,
            complete: currentStep > 0,
        },
        {
            id: '02',
            name: 'UI & Accesibility',
            description: 'Help Yipnyap help you use the internet.',
            href: '#',
            current: currentStep === 1,
            complete: currentStep > 1,
        },
        {
            id: '03',
            name: 'Content Privacy',
            description: 'Specify what you post & who can see it.',
            href: '#',
            current: currentStep === 2,
            complete: currentStep > 2,
        },
        {
            id: '04',
            name: 'Finish',
            description: 'Get a quick rundown.',
            href: '#',
            current: currentStep === 3,
            complete: currentStep > 3,
        },
    ];

    return (
        <>
            <div className="bg-white dark:bg-neutral-700/10 border-0 border-solid border-default md:w-full md:overflow-x-auto lg:border-t">
                <nav className="mx-auto max-w-7xl px-4 sm:px-6 md:w-[max-content] lg:px-8" aria-label="Progress">
                    <ol
                        role="list"
                        className="overflow-hidden rounded-md border-0 border-solid border-default lg:flex lg:rounded-none lg:border-l lg:border-r"
                    >
                        {steps.map((step, stepIdx) => (
                            <li key={step.id} className="relative overflow-hidden lg:flex-1">
                                <div
                                    className={classNames(
                                        stepIdx === 0 ? 'rounded-t-md border-b-0' : '',
                                        stepIdx === steps.length - 1 ? 'rounded-b-md border-t-0' : '',
                                        'overflow-hidden border border-default lg:border-0'
                                    )}
                                >
                                    {step.complete ? (
                                        <a href={step.href} className="group">
                                            <span
                                                className="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-neutral-500/10 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                                                aria-hidden="true"
                                            />
                                            <span
                                                className={classNames(
                                                    stepIdx !== 0 ? 'lg:pl-9' : '',
                                                    'flex items-start px-6 py-5 text-sm font-medium'
                                                )}
                                            >
                                                <span className="flex-shrink-0">
                                                    <span className="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600">
                                                        <CheckIcon className="h-6 w-6 text-white" aria-hidden="true" />
                                                    </span>
                                                </span>
                                                <span className="ml-4 mt-0.5 flex min-w-0 flex-col">
                                                    <span className="text-sm font-medium text-default">{step.name}</span>
                                                    <span className="text-sm font-medium text-default-alt">{step.description}</span>
                                                </span>
                                            </span>
                                        </a>
                                    ) : step.current ? (
                                        <a href={step.href} aria-current="step">
                                            <span
                                                className="absolute left-0 top-0 h-full w-1 bg-indigo-600 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                                                aria-hidden="true"
                                            />
                                            <span
                                                className={classNames(
                                                    stepIdx !== 0 ? 'lg:pl-9' : '',
                                                    'flex items-start px-6 py-5 text-sm font-medium'
                                                )}
                                            >
                                                <span className="flex-shrink-0">
                                                    <span className="flex h-10 w-10 items-center justify-center rounded-full border-2 border-indigo-600">
                                                        <span className="text-primary">{step.id}</span>
                                                    </span>
                                                </span>
                                                <span className="ml-4 mt-0.5 flex min-w-0 flex-col">
                                                    <span className="text-sm font-medium text-primary">{step.name}</span>
                                                    <span className="text-sm font-medium text-default-alt">{step.description}</span>
                                                </span>
                                            </span>
                                        </a>
                                    ) : (
                                        <a href={step.href} className="group">
                                            <span
                                                className="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-neutral-500/10 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                                                aria-hidden="true"
                                            />
                                            <span
                                                className={classNames(
                                                    stepIdx !== 0 ? 'lg:pl-9' : '',
                                                    'flex items-start px-6 py-5 text-sm font-medium'
                                                )}
                                            >
                                                <span className="flex-shrink-0">
                                                    <span className="flex h-10 w-10 items-center justify-center rounded-full border-2 border-neutral-300">
                                                        <span className="text-default-alt">{step.id}</span>
                                                    </span>
                                                </span>
                                                <span className="ml-4 mt-0.5 flex min-w-0 flex-col">
                                                    <span className="text-sm font-medium text-default-alt">{step.name}</span>
                                                    <span className="text-sm font-medium text-default-alt">{step.description}</span>
                                                </span>
                                            </span>
                                        </a>
                                    )}

                                    {stepIdx !== 0 ? (
                                        <>
                                            {/* Separator */}
                                            <div className="absolute inset-0 left-0 top-0 hidden w-3 lg:block" aria-hidden="true">
                                                <svg
                                                    className="h-full w-full text-neutral-300 dark:text-neutral-800"
                                                    viewBox="0 0 12 82"
                                                    fill="none"
                                                    preserveAspectRatio="none"
                                                >
                                                    <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vectorEffect="non-scaling-stroke" />
                                                </svg>
                                            </div>
                                        </>
                                    ) : null}
                                </div>
                            </li>
                        ))}
                    </ol>
                </nav>
            </div>

            <div className="border-0 border-t border-solid border-default py-11">
                <div className="px-4 sm:px-6 lg:px-8">
                    {steps[0].current && <ProfileOnboarding />}
                    {steps[1].current && <UIOnboarding />}
                    {steps[2].current && <PrivacyOnboarding />}
                    {steps[3].current && (
                        <>
                            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8 justify-center items-center">
                                <div className="flex flex-col space-y-4">
                                    <NGHeading>✨ Welcome to Yipnyap ✨</NGHeading>
                                    <div className="space-y-2">
                                        <p className="text-sm text-default-alt">
                                            That's it! You're all set up. You can now start posting, following, and
                                            interacting with other users.
                                        </p>
                                        <p className="text-sm text-default-alt">
                                            Heads up for those who are new to UI3: a <i>lot</i> has changed. We've tried
                                            to keep things as familiar as possible while still making things better(?),
                                            but stuff might be broken. If you find something, please report it on the{' '}
                                            <a href="https://work.yipnyap.me" className="text-primary">bug tracker <ArrowUpRightIcon className="h-4 w-4 inline" /></a>.
                                        </p>
                                    </div>
                                </div>
                                <div className="flex items-center">
                                    <img src={`${yipnyap_constants.yipnyap_url}/img/illustrations/settings/import-begin.png`} alt="LITTLE BABY BOY" className="w-auto" />
                                </div>
                            </div>
                        </>
                    )}
                </div>

                <div className="mt-6 mr-6 flex items-center justify-end">
                    <a className="text-sm leading-5 text-tertiary" href={`/${yipnyap_constants.currentUser?.permaname}/settings/account-settings/`}>
                        Delete Account <ArrowRightIcon className="h-4 w-4 inline" />
                    </a>
                </div>
            </div>
        </>
    )
}

export function ProfileOnboarding() {
    const [handleInput, setHandleInput] = useState<string | null>(yipnyap_constants.currentUser.username)
    const [nicknameInput, setNicknameInput] = useState<string | null>(yipnyap_constants.currentUser.display_name)
    const [aboutInput, setAboutInput] = useState<string | null>(yipnyap_constants.currentUser.bio)

    // Profile pic and cover pic upload fields
    const [profilePicUpload, setProfilePicUpload] = useState<File | null>(null)
    const [coverPicUpload, setCoverPicUpload] = useState<File | null>(null)

    // Profile pic and cover pic upload previews
    const [profilePicPreview, setProfilePicPreview] = useState<string | null>(null)
    const [coverPicPreview, setCoverPicPreview] = useState<string | null>(null)

    useEffect(() => {
        if (profilePicUpload) {
            const reader = new FileReader()
            reader.onloadend = () => {
                setProfilePicPreview(reader.result as string)
            }
            reader.readAsDataURL(profilePicUpload)
        } else {
            setProfilePicPreview(null)
        }
    }, [profilePicUpload])

    useEffect(() => {
        if (coverPicUpload) {
            const reader = new FileReader()
            reader.onloadend = () => {
                setCoverPicPreview(reader.result as string)
            }
            reader.readAsDataURL(coverPicUpload)
        } else {
            setCoverPicPreview(null)
        }
    }, [coverPicUpload])

    function submit() {
        fetch(`/api/v2/member/me`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
            },
            body: JSON.stringify({
                athandle: handleInput,
                display_name: nicknameInput,
                bio: aboutInput,
                // base64 with mime type
                avatar: profilePicPreview,
                header: coverPicPreview,
            })
        }).then(res => res.json()).then(res => {
            if (res.E2ID) {
                // sike this is success
                yipnyap_constants.setDipswitch('NewUserOnboardingStep', 1)
                window.location.reload()
            }
        })
    }

    return (
        <form>
            <div className="space-y-12">
                <NGProfileHeader user={{
                    username: handleInput || yipnyap_constants.currentUser.username,
                    display_name: nicknameInput,
                    bio: aboutInput,
                    avatar: profilePicPreview || yipnyap_constants.currentUser.avatar,
                    header: coverPicPreview || yipnyap_constants.currentUser.header,
                    followers: 69,
                    following: 420,
                    posts: 1337,
                }} />
                <div className="border-b border-neutral-900/10 pb-12">
                    <h2 className="text-base font-semibold leading-7 text-default">Profile</h2>
                    <p className="mt-1 text-sm leading-6 text-default-alt">
                        This information will be displayed publicly so be careful what you share. View above
                        to see how it will look.
                    </p>

                    <div className="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div className="relative sm:col-span-4">
                            <label htmlFor="athandle" className="block text-sm font-medium leading-6 text-default">
                                Username & @handle
                                <p className="mt-1 text-xs leading-5 text-default-alt">
                                    Your first username is bound to you forever, but you can change your @handle anytime.
                                </p>
                            </label>
                            <div className="mt-2">
                                <div className="flex rounded-md bg-default shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-800 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <span className="flex select-none items-center pl-3 text-neutral-500 sm:text-sm">yipnyap.me/{yipnyap_constants.currentUser.permaname}</span>
                                    <input
                                        disabled
                                        type="text"
                                        id="username"
                                        className="no-legacy block flex-1 border-0 bg-transparent py-1.5 pl-1 text-default placeholder:text-neutral-400 focus:ring-0 sm:text-sm sm:leading-6"
                                    />
                                </div>
                            </div>

                            <div className="mt-2 flex justify-center items-center cursor-help sm:max-w-md"
                                 title="Icongraphy meaning: Arrow Up & Down = username will be used, Arrow Down = @handle will be used">
                                {(handleInput !== yipnyap_constants.currentUser.permaname) ? (
                                    <ChevronDownIcon className="h-6 w-6 text-default-alt" aria-hidden="true" />
                                ) : (
                                    <ChevronUpDownIcon className="h-6 w-6 text-default-alt" aria-hidden="true" />
                                )}
                            </div>

                            <div className="mt-2">
                                <div className="flex rounded-md bg-default shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-800 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <span className="flex select-none items-center pl-3 text-neutral-500 sm:text-sm">@</span>
                                    <input
                                        type="text"
                                        name="athandle"
                                        id="athandle"
                                        autoComplete="athandle"
                                        className="no-legacy block flex-1 border-0 bg-transparent py-1.5 pl-1 text-default placeholder:text-neutral-400 focus:ring-0 sm:text-sm sm:leading-6"
                                        placeholder={yipnyap_constants.currentUser.username}
                                        onChange={(e) => setHandleInput(e.target.value)}
                                    />
                                </div>
                                <p className="mt-1 text-xs leading-5 text-default-alt">
                                    This replaces your original username, and can be changed anytime.
                                </p>
                            </div>
                        </div>

                        <div className="sm:col-span-4">
                            <label htmlFor="display_name" className="block text-sm font-medium leading-6 text-default">
                                Display Name
                            </label>
                            <div className="mt-2">
                                <div className="flex rounded-md bg-default shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-800 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md"><input
                                        type="text"
                                        name="display_name"
                                        id="display_name"
                                        autoComplete="display_name"
                                        className="no-legacy block flex-1 border-0 bg-transparent py-1.5 px-3 text-default placeholder:text-neutral-400 focus:ring-0 sm:text-sm sm:leading-6"
                                        placeholder="Some Display Name"
                                        onChange={(e) => setNicknameInput(e.target.value)}
                                    />
                                </div>
                            </div>
                            <p className="mt-3 text-sm leading-6 text-default-alt">This appears alongside your username.</p>
                        </div>

                        <div className="col-span-full">
                            <label htmlFor="about" className="block text-sm font-medium leading-6 text-default">
                                About
                            </label>
                            <div className="mt-2">
                                <textarea
                                    id="about"
                                    name="about"
                                    rows={3}
                                    className="no-legacy block w-full rounded-md border-0 py-1.5 text-default bg-default shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-800 placeholder:text-neutral-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    defaultValue={yipnyap_constants.currentUser.bio || ''}
                                    onChange={(e) => setAboutInput(e.target.value)}
                                />
                            </div>
                            <p className="mt-3 text-sm leading-6 text-default-alt">
                                Write a few sentences about yourself. <a href="https://commonmark.org/help/" target="_blank" className="text-primary">Markdown <ArrowUpRightIcon className="h-4 w-4 inline" /></a> is supported.
                            </p>
                        </div>

                        <div className="col-span-full">
                            <label htmlFor="avatar" className="block text-sm font-medium leading-6 text-default">
                                Photo
                            </label>
                            <input type="file" name="avatar" id="avatar" className="hidden" onChange={(e) => setProfilePicUpload(e.target.files?.[0] || null)} />
                            <div className="mt-2 flex items-center gap-x-3">
                                {!profilePicPreview
                                    ? <UserCircleIcon className="h-12 w-12 text-default-alt" aria-hidden="true" />
                                    : <NGAvatar image={profilePicPreview} size="lg" />
                                }
                                <NGButton onClick={() => document.getElementById('avatar')?.click()}>
                                    Upload
                                </NGButton>
                            </div>
                            <p className="mt-3 text-sm leading-6 text-default-alt">
                                We don't resize your photo. Scroll up to the header to see how it will look.
                            </p>
                        </div>

                        <div className="col-span-full">
                            <label htmlFor="cover-photo" className="block text-sm font-medium leading-6 text-default">
                                Cover photo
                            </label>
                            <div className="relative aspect-banner mt-2 flex items-center justify-center rounded-lg border border-dashed border-default px-6 py-10 cursor-pointer overflow-hidden" onClick={() => document.getElementById('cover-photo')?.click()}>
                                {coverPicPreview && (
                                    <img src={coverPicPreview} alt="" className="absolute inset-0 w-full h-full object-cover rounded-lg blur-lg opacity-50" />
                                )}
                                <div className="text-center items-center justify-center">
                                    <PhotoIcon className="mx-auto h-12 w-12 text-default-alt" aria-hidden="true" />
                                    <div className="mt-4 flex text-sm leading-6 text-default-alt">
                                        <label
                                            htmlFor="cover-photo"
                                            className="relative cursor-pointer rounded-md font-semibold text-primary focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
                                        >
                                            <span>Upload a file</span>
                                            <input id="cover-photo" name="file-upload" type="file" className="sr-only" onChange={(e) => setCoverPicUpload(e.target.files?.[0] || null)} />
                                        </label>
                                        <p className="pl-1">(drag and drop not supported)</p>
                                    </div>
                                    <p className="text-xs leading-5 text-default-alt">PNG, JPG, GIF up to 10MB, Aspect Ratio 3 / 1</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="mt-6 flex items-center justify-end gap-x-6">
                <NGButton variant="primary" onClick={submit}>
                    Save
                </NGButton>
            </div>
        </form>
    )
}

export function UIOnboarding() {
    return (
        <div className="flex flex-col space-y-8 max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8">
            <SettingsAccessibility DONTFUCKINGPADTHEUI />
            <SettingsSkin inline />

            <div className="flex justify-end">
                <NGButton variant="primary" onClick={() => {
                    yipnyap_constants.setDipswitch('NewUserOnboardingStep', 2)
                    window.location.reload()
                }}>
                    Save
                </NGButton>
            </div>
        </div>
    )
}

export function PrivacyOnboarding() {
    const [showNSFW, setShowNSFW] = useState(false);
    const [isAD, setIsAD] = useState(false);

    useEffect(() => {
        if (!showNSFW && isAD) {
            setIsAD(false)
        }
    }, [showNSFW, isAD])

    return (
        <form>
            <div className="space-y-12">
                <div className="border-b border-neutral-900/10 pb-12">
                    <h2 className="text-base font-semibold leading-7 text-default">Content you see & who sees yours</h2>
                    <p className="mt-1 text-sm leading-6 text-default-alt">
                        Control what you want to see, as well as who can see and interact with your profile.
                    </p>

                    <div className="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div className="sm:col-span-4">
                            <NGSwitch
                                enabled={showNSFW}
                                reverse
                                title="Show NSFW content"
                                description="Show content marked as NSFW by other users. You can always view
                                the content by visiting their profile or the post directly."
                                onChange={(e: boolean) => setShowNSFW(e)}
                            />
                            {/* NSFW 18+ requirement supplement */}
                            <p className="mt-1 text-xs leading-5 text-default-alt">
                                <span className="font-semibold text-tertiary">Enabling this, you agree that you are 18+
                                    years old.</span> Minors will be prosecuted based on our Guidelines.
                            </p>
                        </div>

                        <div className="sm:col-span-4">
                            <NGSwitch
                                enabled={isAD}
                                disabled={!showNSFW}
                                reverse
                                title="Move this account to Afterdark"
                                description="Only other AD accounts can see and interact with your profile. You do not
                                need to enable this to view and post NSFW content."
                                onChange={(e: boolean) => setIsAD(e)}
                            />
                            {/* ... you know the drill. maybe make this a component? */}
                            <p className="mt-1 text-xs leading-5 text-default-alt">
                                <span className="font-semibold text-tertiary">Enabling this, you agree that you are 18+
                                    years old.</span> Minors will be prosecuted based on our Guidelines.
                            </p>
                        </div>

                        <div className="col-span-full">
                            <label htmlFor="blocklist" className="block text-sm font-medium leading-6 text-default">
                                Import a blocklist
                            </label>
                            <div className="mt-2">
                                <textarea
                                    id="blocklist"
                                    name="blocklist"
                                    rows={3}
                                    className="no-legacy block w-full rounded-md border-0 py-1.5 text-default bg-default shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-800 placeholder:text-neutral-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    defaultValue={''}
                                />
                            </div>
                            <p className="mt-3 text-sm leading-6 text-default-alt">
                                A comma-separated list of usernames to immediately block before your account goes
                                live. You can always add more later. You can block usernames that aren't yet
                                registered, but you may accidentally block someone else.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div className="mt-6 flex items-center justify-end gap-x-6">
                <NGButton variant="primary">
                    Save
                </NGButton>
            </div>
        </form>
    )
}