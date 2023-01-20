import React, {Fragment, useEffect, useRef, useState} from 'react';
import {useHeading} from "../../../../../../providers/PageHeading.provider";
import {buildClassObject} from "../../../../utils/ColourScheme.utils";
import {ArrowRightCircleIcon, LockClosedIcon} from "@heroicons/react/20/solid";
import {Tab, Dialog, Transition} from "@headlessui/react";

export const ButtonTheming = {
    main: [],
    button: ['w-full', 'inline-flex', 'justify-center',
        'shadow-sm', 'bg-default', 'text-sm', 'font-medium', 'text-default',
        'hover:bg-neutral-50 dark:hover:bg-neutral-700'],
    buttonPrimary: ['w-full', 'inline-flex', 'justify-center',
        'shadow-sm', 'text-blue-500', 'text-sm', 'font-medium',
        'hover:bg-blue-500 hover:bg-opacity-25'],

    tab: ['relative', 'flex-1', 'rounded', 'py-2', 'px-4', 'text-sm', 'font-medium', 'focus:outline-none'],
    tabSelected: ['bg-neutral-200', 'dark:bg-neutral-700', 'text-neutral-900', 'dark:text-neutral-100'],
    tabVoid: ['text-neutral-500', 'dark:text-neutral-400']
}

function SetupDialog({...props}) {
    /**
     * This is an attempt at using GNOME Human Interface Guidelines & Adwaita styling. Testing the waters.
     * See https://developer.gnome.org/hig/
     */

    const [isOpen, setIsOpen] = useState(false);
    const [selectedIndex, setSelectedIndex] = useState(0);

    const [telegramUsername, setTelegramUsername] = useState('');

    function closeModal() {
        setIsOpen(false);
    }

    function openModal() {
        setSelectedIndex(0);
        setIsOpen(true)
    }

    function setNextTab() {
        if (selectedIndex < (SetupGroups.length - 1)) {
            setSelectedIndex(selectedIndex + 1);
        }
    }

    const SetupGroups = [
        {
            name: 'Welcome',
            description: 'Welcome to the setup wizard. This will guide you through the setup process.',
            children:
                <>
                    {/* Image on left, top on mobile */}
                    <div className="flex flex-col md:flex-row">
                        <div className="flex flex-col items-center justify-center w-full md:w-1/2">
                            <img src={`${yipnyap_constants.yipnyap_url}/img/illustrations/onboarding/bao-searching.png`}
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
                                    If you'd like to claim this Yipnyap account, you will need a Telegram
                                    account that has a verified phone number. If you don't have a verified
                                    phone number, you can still use Yipnyap, but you will not be able to
                                    reset your password, use the Yipnyap Market, view explicit content
                                    (depending on region), or request a storage quota increase.
                                </p>
                                <div className="flex gap-1 text-sm text-secondary">
                                    <LockClosedIcon className="h-5 w-5"/><b>Yipnyap can't send or read messages, or
                                    otherwise do any action via Telegram Passport.</b>
                                    <span className="text-alt-2">
                                        Telegram gives us barebones, read-only data, which is shared only once per
                                        authorisation via this wizard.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </>
        },
        {
            name: 'Prepare',
            description: 'Configure your Telegram @username',
            children:
                <div className="flex flex-col gap-4 max-w-lg">
                    <h2>What is your Telegram @{telegramUsername || 'ID'}?</h2>
                    <p className="text-sm text-alt-2">Enter your Telegram @ID below. Don't provide the link, just the
                        username!</p>

                    <div className="max-w-2xl relative text-neutral-400 focus-within:text-neutral-500">
                        <label htmlFor="telegram-id"
                               className="sr-only">
                            Telegram ID
                        </label>
                        <div className="mt-1 relative rounded-default shadow-sm">
                            <input type="text" name="search" id="telegram-id"
                                   className="highlight-main block w-full max-h-9"
                                   placeholder="Telegram @ID" value={telegramUsername}
                                   onChange={e => setTelegramUsername(e.target.value)}/>
                        </div>
                    </div>
                </div>
        },
        {
            name: 'Authorise',
            description: 'Authorise Yipnyap to access your Telegram account',
            children:
                <div className="flex flex-col gap-4 max-w-lg">
                    <h2>Authorise Telegram Passport</h2>
                    <p className="text-sm text-alt-2">Your Telegram Chat #, Username, and whether or not a Phone Number
                        exists, <b>will be stored on Yipnyap until you deauthorise</b>. Yipnyap will not store any other
                        information about your Telegram account.</p>
                    <p className="text-sm text-alt-2">Your Phone Number will be processed, however it will be discarded.
                        A true/false value will be stored instead, confirming the validity of the number.</p>
                    <div className="flex gap-2 items-center text-default text-sm">
                        <img className="animate-spin dark:invert"
                             src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
                             width="16" height="16" alt="Process working spinner"/>
                        Connection Check
                    </div>
                </div>
        },
        {
            name: 'Process',
            description: 'Allow Yipnyap to process the data it receives from Telegram',
            children:
                <>
                    <h2 className="flex gap-2 items-center">
                        <img className="h-5 w-5 animate-spin dark:invert"
                             src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
                             alt="Process working spinner"/>
                        Wait for Yipnyap to digest
                    </h2>
                </>
        }
    ]

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
                        <div className="flex h-full md:min-h-full md:p-4 text-center">
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
                                    className="w-full md:m-12 lg:m-24 flex flex-col transform overflow-hidden rounded-2xl bg-box-solid text-left align-middle shadow-xl transition-all border border-solid border-divider">
                                    <div className="p-12 flex-1 overflow-scroll">
                                        <Tab.Group selectedIndex={selectedIndex} onChange={setSelectedIndex}>
                                            <Tab.List
                                                className="flex max-w-lg p-1 space-x-1 bg-neutral-100 dark:bg-neutral-800 rounded mx-auto">
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
                                                        {group.children}
                                                    </Tab.Panel>
                                                ))}
                                            </Tab.Panels>
                                        </Tab.Group>
                                    </div>

                                    <div
                                        className="flex flex-col md:flex-row sticky bottom-0 items-center justify-center w-full border-t border-b-0 border-x-0 border-solid border-divider divide-x divide-y-0 divide-solid divide-neutral-300 dark:divide-neutral-700">
                                        <button
                                            type="button"
                                            className={`${props.theme.button} p-4 rounded-none`}
                                            onClick={closeModal}
                                        >
                                            Cancel
                                        </button>

                                        <button
                                            type="button"
                                            className={`${props.theme.buttonPrimary} p-4 rounded-none`}
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
                className={`${props.theme.button} py-2 px-4`}
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

    useEffect(() => {
        if (heading?.heading !== 'Telegram') {
            setHeading({
                heading: 'Telegram',
                padding: true,
                navigator: heading?.navigator,
            })
        }
    });

    return (
        <>
            <div className="flex">
                <div className="flex-1 gap-x-4">
                    <h2 className="text-2xl font-bold">Setup Telegram to receive Login OTPs and other
                        Notifications.</h2>
                </div>

                {/* Get Started button */}
                <div className="max-w-md my-auto">
                    <SetupDialog theme={theme}/>
                </div>
            </div>
        </>
    )
}
