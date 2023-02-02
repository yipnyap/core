import React, {Fragment, useEffect, useRef, useState} from 'react';
import {useHeading} from "../../../../../../providers/PageHeading.provider";
import {buildClassObject} from "../../../../utils/ColourScheme.utils";
import {ArrowRightCircleIcon, CheckBadgeIcon, LockClosedIcon, PaperAirplaneIcon} from "@heroicons/react/20/solid";
import {Tab, Dialog, Transition} from "@headlessui/react";
import {useLocation} from "react-router-dom";
import {NGCard, NGWizard, NGSwitch} from "../../../../components";

export const ButtonTheming = {
    main: [],
    button: ['w-full', 'inline-flex', 'justify-center',
        'shadow-sm', 'text-sm', 'font-medium', 'text-default',
        'hover:bg-neutral-50 dark:hover:bg-neutral-700'],
    buttonPrimary: ['w-full', 'inline-flex', 'justify-center',
        'shadow-sm', 'text-blue-500', 'text-sm', 'font-medium',
        'hover:bg-blue-500 hover:bg-opacity-25'],
    buttonTelegram: ['w-full', 'inline-flex', 'justify-center',
        'shadow-sm', 'text-white', 'text-sm', 'font-medium',
        'bg-blue-500', 'hover:bg-blue-400', 'dark:hover:bg-blue-600'],

    tab: ['relative', 'flex-1', 'rounded', 'py-2', 'px-4', 'text-sm', 'font-medium', 'focus:outline-none'],
    tabSelected: ['bg-neutral-200', 'dark:bg-neutral-700', 'text-neutral-900', 'dark:text-neutral-100'],
    tabVoid: ['text-neutral-500', 'dark:text-neutral-400']
}

let TelegramAuthData: TelegramResponseType;

function SetupDialog({...props}) {
    /**
     * This is an attempt at using GNOME Human Interface Guidelines & Adwaita styling. Testing the waters.
     * See https://developer.gnome.org/hig/
     */

    const [isOpen, setIsOpen] = useState(false);
    const [selectedIndex, setSelectedIndex] = useState(0);

    const allowNext = useRef(true);
    const reloadWhenWizardFinish = useRef(true);
    const dialog = useRef<HTMLDivElement>(null);
    const dialogInner = useRef<HTMLDivElement>(null);

    function closeModal() {
        setIsOpen(false);
    }

    function openModal() {
        setSelectedIndex(0);
        setIsOpen(true)
    }

    function setNextTab() {
        if (!allowNext.current) return;
        if (selectedIndex < (SetupGroups.length - 1)) {
            setSelectedIndex(selectedIndex + 1);
        } else {
            closeModal();
            if (reloadWhenWizardFinish.current) {
                window.location.reload();
            }
        }
    }

    const SetupGroups = [
        {
            name: 'Welcome',
            description: 'Welcome to the setup wizard. This will guide you through the setup process.',
            children: () => {
                allowNext.current = true;

                return (
                    <>
                        {/* Image on left, top on mobile */}
                        <div className="flex flex-col md:flex-row">
                            <div className="flex flex-col items-center justify-center w-full md:w-1/2">
                                <img
                                    src={`${yipnyap_constants.yipnyap_url}/img/illustrations/onboarding/bao-searching.png`}
                                    alt="Bao searching through files and books" className="w-1/2"/>
                            </div>
                            <div className="flex flex-col items-center justify-center w-full md:w-1/2">
                                <Dialog.Title
                                    as="h2"
                                >
                                    Important information regarding Telegram Linkage
                                </Dialog.Title>
                                <div className="flex flex-col mt-8 gap-y-4">
                                    <p className="text-sm text-alt-2">
                                        While it's convenient and more secure to link your Telegram account
                                        to your Yipnyap account, setup is a bit more involved. You will need
                                        your Telegram app ready. This is a one-time setup process, and you
                                        will be able to unlink your Telegram account at any time.
                                    </p>
                                    <p className="text-sm text-alt-2">
                                        If you refuse to claim this account, you can still use Yipnyap, but you will
                                        not be able to reset your password, use the Yipnyap Market, view explicit
                                        content
                                        (depending on region), or request a storage quota increase.
                                    </p>
                                    <p className="text-sm text-tertiary">
                                        Multiple accounts will be privately linked together. No one will be able
                                        to find your other accounts through this, however Yipnyap staff can.
                                    </p>
                                    <hr/>
                                    <h2>Few things to note</h2>
                                    <div className="flex flex-col gap-y-4">
                                        <div className="gap-x-2">
                                            <div className="flex flex-row gap-x-2 text-secondary items-center">
                                                <LockClosedIcon className="h-5 w-5"/><b>Yipnyap can't interact as
                                                you on Telegram.</b>
                                            </div>
                                            <p className="text-sm text-alt-2">
                                                Telegram gives us barebones, read-only data, which is shared only once
                                                per authorisation via this wizard. The following is sent to Yipnyap:
                                            </p>
                                            <ul className="text-sm text-alt-2 list-disc list-inside">
                                                <li>Telegram ID (<code>id</code>) - Used to send you messages</li>
                                            </ul>
                                        </div>
                                        <div className="gap-x-2">
                                            <div className="flex flex-row gap-x-2 text-secondary items-center">
                                                <LockClosedIcon className="h-5 w-5"/><b>Login via Telegram only grants
                                                access to send messages to you via @yipnyapbot.</b>
                                            </div>
                                            <p className="text-sm text-alt-2">
                                                Telegram requires bots to verify that you allow them to send you
                                                messages. This is a one-time process, and you can revoke access at any
                                                time.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </>
                )
            }
        },
        {
            name: 'Authorise',
            description: 'Authorise Yipnyap to access your Telegram account',
            children: () => {
                const [isAuthorising, setIsAuthorising] = useState(false);
                const [telegramUsername, setTelegramUsername] = useState('');
                const [telegramUsernameError, setTelegramUsernameError] = useState('');
                const [telegramAuthData, setTelegramAuthData] = useState<TelegramResponseType>();

                allowNext.current = false;

                function doAuth() {
                    setIsAuthorising(true);
                    window.Telegram.Login.auth({
                        request_access: 'write',
                        bot_id: yipnyap_constants.telegram_bot,
                    }, (result) => {
                        setIsAuthorising(false);
                        setTelegramAuthData(result);

                        if (result.username) {
                            TelegramAuthData = result;
                            allowNext.current = true;
                        } else {
                            setTelegramUsernameError(`You need to set a username in your Telegram account.`);
                        }
                    })
                }

                return (
                    <div className="flex flex-col max-w-lg">
                        <div className="flex flex-col gap-y-2">
                            <h2>Authorise via Telegram Login</h2>
                            <p className="text-sm text-alt-2">
                                Click the button below to authorise Yipnyap to access your
                                Telegram account basic information (username, display name, etc.). We can't do any
                                action as you.
                            </p>

                            {
                                telegramUsernameError &&
                                <p className="text-sm text-tertiary">{telegramUsernameError}</p>
                            }

                            {
                                !telegramAuthData
                                    ? (
                                        <div className="flex justify-center">
                                            <button
                                                type="button"
                                                className={`${props.theme.buttonTelegram} ${isAuthorising && 'bg-opacity-75 cursor-wait'} w-1/2 py-2 px-4`}
                                                disabled={isAuthorising}
                                                onClick={doAuth}
                                            >
                                                {
                                                    isAuthorising
                                                        ? <img className="-ml-1 mr-2 h-5 w-5 animate-spin dark:invert"
                                                               src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
                                                               alt="Process working spinner"/>
                                                        : <PaperAirplaneIcon className="-ml-1 mr-2 h-5 w-5"
                                                                             aria-hidden="true"/>

                                                }

                                                <span>Login via Telegram</span>
                                            </button>
                                        </div>
                                    )
                                    : (
                                        <div className="flex flex-col gap-y-2">
                                            <h3>Telegram account to be linked:</h3>
                                            <div className="flex gap-x-2 items-center text-default">
                                                <img className="h-8 w-8 rounded-full" src={telegramAuthData.photo_url}
                                                     alt="Telegram profile picture"/>
                                                <div className="flex flex-col">
                                                    <p className="text-sm">
                                                        <b>{`${telegramAuthData.first_name} ${telegramAuthData.last_name || ''}`}</b>
                                                    </p>
                                                    <p className="text-sm font-medium text-alt-2">
                                                        @{telegramAuthData.username}
                                                    </p>
                                                    <p className="text-sm font-medium text-alt-2">
                                                        ID {telegramAuthData.id}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    )
                            }
                        </div>
                    </div>
                )
            }
        },
        {
            name: 'Process',
            description: 'Allow Yipnyap to process the data it receives from Telegram',
            children: () => {
                const [isProcessing, setIsProcessing] = useState(true);
                const [patchError, setPatchError] = useState();
                const [status, setStatus] = useState('Yipnyap is waiting');

                allowNext.current = false;

                useEffect(() => {
                    setTimeout(() => {
                        setStatus('Yipnyap is working')
                        // Send via PATCH /api/v2/telegram
                        fetch(`/api/v2/telegram`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
                            },
                            body: JSON.stringify({
                                id: TelegramAuthData.id,
                            })
                        }).then(response => {
                            setStatus('Client is processing')
                            setTimeout(() => {
                                response.json().then(data => {
                                    if (data.success) {
                                        setIsProcessing(false);
                                        allowNext.current = true;
                                    }
                                })
                            }, 1000)
                        })
                    }, 2000)
                }, [])
                return (
                    <>
                        {
                            isProcessing && (
                                <div className="flex flex-col gap-y-4 max-w-lg">
                                    <h2 className="flex gap-2 items-center">
                                        Finish up
                                    </h2>

                                    <div className="flex gap-2 items-center text-default text-sm">
                                        <img className="animate-spin dark:invert"
                                             src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
                                             width="16" height="16" alt="Process working spinner"/>
                                        {status || 'Yipnyap is working'}...
                                    </div>
                                </div>
                            )
                        }

                        {
                            !isProcessing && (
                                <div className="flex flex-col gap-y-4 max-w-lg">
                                    <h2>👍 All done!</h2>
                                    <p className="text-sm text-alt-2">
                                        Your Yipnyap account is now linked to your Telegram account. From here
                                        on out, you'll need to use Telegram as 2-factor authentication for
                                        Yipnyap.
                                    </p>
                                    <p className="text-sm text-alt-2">
                                        You can deauthorise Yipnyap from your Telegram account at any time by
                                        clicking the "Deauthorise" button on the Yipnyap settings page.
                                    </p>
                                    <p className="text-sm text-alt-2">
                                        👋 <b>Yipnyap will now reload.</b>
                                    </p>
                                </div>
                            )
                        }
                    </>
                )
            }
        }
    ]

    requestAnimationFrame(() => {
        if (dialog.current && dialogInner.current) {
            dialog.current.style.width = `${dialogInner.current.scrollWidth}px`;
            dialog.current.style.height = `${dialog.current.offsetHeight}px`;
        }
    })

    return (
        <>
            <Transition appear show={isOpen} as={Fragment}>
                <Dialog as="div" className="relative" style={{zIndex: '900'}} onClose={closeModal}>
                    <Transition.Child
                        as={Fragment}
                        enter="ease-out duration-300"
                        enterFrom="opacity-0"
                        enterTo="opacity-100"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                    >
                        <div className="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-md"/>
                    </Transition.Child>

                    <div className="fixed inset-0 overflow-y-auto">
                        <div className="flex h-full md:min-h-full md:p-4 lg:p-12 xl:p-24 text-center">
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
                                    ref={dialog}
                                    className="max-h-full m-auto flex flex-col transform overflow-hidden rounded-2xl bg-box-solid text-left align-middle shadow-xl transition-all border border-solid border-divider"
                                >
                                    <div ref={dialogInner} className="w-fit h-fit p-12 flex-1 overflow-scroll">
                                        <Tab.Group selectedIndex={selectedIndex} onChange={setSelectedIndex}>
                                            <Tab.List
                                                className="flex max-w-lg p-1 space-x-1 bg-neutral-100 dark:bg-neutral-800 rounded mx-auto pointer-events-none">
                                                {SetupGroups.map((group, index) => (
                                                    <Tab
                                                        key={index}
                                                        className={({selected}) => `${selected ? props.theme.tabSelected : (index < selectedIndex ? 'text-default bg-emerald-300 dark:bg-emerald-700 bg-opacity-25' : props.theme.tabVoid)} ${props.theme.tab}`}
                                                    >
                                                        <span>{group.name}</span>
                                                    </Tab>
                                                ))}
                                            </Tab.List>
                                            <Tab.Panels className="mt-4">
                                                {SetupGroups.map((group, index) => (
                                                    <Tab.Panel key={index}>
                                                        <group.children/>
                                                    </Tab.Panel>
                                                ))}
                                            </Tab.Panels>
                                        </Tab.Group>
                                    </div>

                                    <div
                                        className="flex flex-col md:flex-row sticky bottom-0 items-center justify-center w-full border-t border-b-0 border-x-0 border-solid border-divider divide-x divide-y-0 divide-solid divide-neutral-300 dark:divide-neutral-700">
                                        <button
                                            type="button"
                                            className={`${props.theme.button} bg-default p-4 rounded-none`}
                                            onClick={closeModal}
                                        >
                                            Cancel
                                        </button>

                                        <button
                                            type="button"
                                            className={`${props.theme.buttonPrimary} bg-default p-4 rounded-none`}
                                            onClick={setNextTab}
                                        >
                                            Continue
                                        </button>
                                    </div>
                                </Dialog.Panel>
                            </Transition.Child>
                        </div>
                    </div>
                </Dialog>
            </Transition>
            <button
                type="button"
                className={`${props.theme.button} bg-default py-2 px-4`}
                onClick={openModal}
            >
                <ArrowRightCircleIcon className="-ml-1 mr-2 h-5 w-5 text-neutral-400 dark:text-white"
                                      aria-hidden="true"/>
                <span>Get Started</span>
            </button>
        </>
    )
}

export default function SettingsTelegram({...props}) {
    let theme = buildClassObject(ButtonTheming, 'neutral');
    const [heading, setHeading] = useHeading();
    const location = useLocation();

    const [showUnlinkDialog, setShowUnlinkDialog] = useState(false);
    const [telegramIsAllowed, setTelegramIsAllowed] = useState(true);

    useEffect(() => {
        if (heading?.heading !== 'Telegram' && !props.onlyShowOnboarding) {
            setHeading({
                heading: !yipnyap_constants.currentUser?.tgid ? 'Telegram' : null,
                padding: true,
                navigator: heading?.navigator,
            })
        }
    }, [location.pathname]);

    function doTelegramUnlink() {
        fetch('/api/v2/telegram', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
            },
        })
            .then((res) => res.json())
            .then((res) => {
                if (res.success) {
                    window.location.reload()
                }
            }).catch(alert)
    }

    return (
        <div className="mb-8">
            {(yipnyap_constants.currentUser && !yipnyap_constants.currentUser.tgid && !telegramIsAllowed) && (
                <div className="flex flex-row space-x-4 justify-center items-center">
                    <div className="flex-1 mr-auto space-y-4 max-w-lg">
                        <h2 className="text-2xl font-bold">Telegram linkage unavailable</h2>
                        <p className="text-sm text-alt-2">
                            Linking Telegram is currently disabled. You can still unlink your Telegram
                            account, but you will not be able to link it again until this feature
                            is available again.
                        </p>
                        {yipnyap_constants.notices?.tgLink && (
                            <p className="text-sm text-alt-2">
                                <span className="text-blue-500">From Staff</span>: {yipnyap_constants.notices?.tgLink}
                            </p>
                        )}
                    </div>

                    <div className="max-w-md my-auto">
                        <img
                            src={`${yipnyap_constants.yipnyap_url}/img/illustrations/lost-boi.png`}
                            alt="Telegram header image" className="h-48"/>
                    </div>
                </div>
            )}
            {(!yipnyap_constants.currentUser?.tgid && telegramIsAllowed) && (
                <div className="flex">
                    <div className="flex-1 mr-auto gap-x-4 max-w-lg">
                        <h2 className="text-2xl font-bold">Setup Telegram to claim this account.</h2>
                        <p className="text-sm">
                            Yipnyap uses Telegram to verify your account. You will need to create a Telegram
                            account if you don't already have one.
                        </p>
                        <p className="text-sm text-tertiary">
                            You must connect your Telegram account to be able to recover your account. In
                            some regions, you might not be able to view explicit content until you connect your
                            Telegram account with a valid phone number.
                        </p>
                    </div>

                    {/* Get Started button */}
                    <div className="max-w-md my-auto">
                        <SetupDialog theme={theme}/>
                    </div>
                </div>
            )}

            {yipnyap_constants.currentUser?.tgid && (
                <div className="flex flex-col space-y-4">
                    {/* Header w/ image */}
                    <div className="flex flex-row space-x-4 justify-center items-center">
                        <div className="flex-1 mr-auto space-y-4">
                            <h2 className="text-2xl font-bold">Manage Telegram</h2>
                            {!telegramIsAllowed && (
                                <p className="text-sm text-tertiary">
                                    Linking Telegram is currently disabled. You can still unlink your Telegram
                                    account, but you will not be able to link it again until this feature
                                    is available again.
                                </p>
                            )}
                        </div>

                        <div className="max-w-md my-auto">
                            <img
                                src={`${yipnyap_constants.yipnyap_url}/img/illustrations/onboarding/girl-loudspeaker-announcement.png`}
                                alt="Telegram header image" className="h-48"/>
                        </div>
                    </div>

                    {/* Notification toggles */}
                    <NGCard title="Notifications" wellBody={true}>
                        <div className="flex flex-col space-y-4">
                            <p className="text-sm text-alt-2">
                                These settings only affect the notifications we send you via Telegram, and not
                                the notifications you get on Yipnyap.
                            </p>
                            <NGSwitch enabled disabled title="Account Security"
                                      description="Notifications related to sign ins, failed attempts, et cetera. You cannot disable this."/>
                            <NGSwitch disabled title="Yipnyap Updates"
                                      description={'Sorry, you cannot change this setting at this time (current value: "NO").'}/>
                        </div>
                    </NGCard>

                    {/* Telegram Unlink */}
                    <NGWizard isOpen={showUnlinkDialog} onChange={doTelegramUnlink} dontAnimate={true} theme={theme}>
                        <div className="flex flex-col gap-4 max-w-lg">
                            <h2>Are you sure?</h2>
                            <p className="text-sm text-alt-2">
                                You won't be able to reset your password, as well as other features,
                                if you unlink your Telegram account. You'll have to do the setup again if you
                                want to relink.
                            </p>
                        </div>
                    </NGWizard>
                    <NGCard title="Unlink Telegram" wellBody={true}>
                        <div
                            className="flex flex-col lg:flex-row space-y-4 lg:space-x-4 lg:space-y-0 justify-center items-center">
                            <p className="mr-auto text-sm text-alt-2">
                                Unlinking your Telegram will put your account at risk of being lost, as well as other
                                limits.
                            </p>

                            <button
                                type="button"
                                className={`${theme.button} bg-red-500 dark:bg-red-700 hover:bg-red-400 dark:hover:bg-red-800 py-2 px-4 max-w-md`}
                                onClick={() => setShowUnlinkDialog(true)}
                            >
                                Unlink
                            </button>
                        </div>
                    </NGCard>
                </div>
            )}
        </div>
    )
}
