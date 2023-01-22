import React, {Fragment, useRef, useState} from "react";
import {Dialog, Tab, Transition} from "@headlessui/react";
import {buildClassObject} from "../../utils/ColourScheme.utils";
import {ButtonTheming} from "../../pages/profile/pages/settings/telegram";

export default function NGWizard(props: {
    theme?: any;
    groups?: any;
    open?: any;
    onClose?: any;
    children?: JSX.Element;
    reloadWhenFinish?: boolean
}) {
    const {groups, reloadWhenFinish, open, onClose, children} = props;
    let {theme} = props

    if (!theme) theme = buildClassObject(ButtonTheming, 'neutral');

    /**
     * This is an attempt at using GNOME Human Interface Guidelines & Adwaita styling. Testing the waters.
     * See https://developer.gnome.org/hig/
     */

    const [isOpen, setIsOpen] = useState(open || false);
    const [selectedIndex, setSelectedIndex] = useState(0);

    const allowNext = useRef(true);
    const reloadWhenWizardFinish = useRef(reloadWhenFinish || false);

    function closeModal() {
        setIsOpen(false);
        onClose && onClose();
    }

    function openModal() {
        setSelectedIndex(0);
        setIsOpen(true)
    }

    function setNextTab() {
        if (!allowNext.current) return;
        if (groups && selectedIndex < (groups.length - 1)) {
            setSelectedIndex(selectedIndex + 1);
        } else {
            closeModal();
            if (reloadWhenWizardFinish.current) {
                window.location.reload();
            }
        }
    }

    return (
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
                                    {
                                        !children
                                            ? <Tab.Group selectedIndex={selectedIndex} onChange={setSelectedIndex}>
                                                <Tab.List
                                                    className="flex max-w-lg p-1 space-x-1 bg-neutral-100 dark:bg-neutral-800 rounded mx-auto pointer-events-none">
                                                    {groups.map((group: { name: string, description: string, children: () => JSX.Element }, index: React.Key | null | undefined) => (
                                                        <Tab
                                                            key={index}
                                                            className={({selected}) => `${selected ? theme.tabSelected : ((index || 0) < selectedIndex ? 'text-default bg-emerald-300 dark:bg-emerald-700 bg-opacity-25' : theme.tabVoid)} ${theme.tab}`}
                                                        >
                                                            <span>{group.name}</span>
                                                        </Tab>
                                                    ))}
                                                </Tab.List>
                                                <Tab.Panels className="mt-4">
                                                    {groups.map((group: { name: string, description: string, children: () => JSX.Element }, index: React.Key | null | undefined) => (
                                                        <Tab.Panel key={index}>
                                                            <group.children/>
                                                        </Tab.Panel>
                                                    ))}
                                                </Tab.Panels>
                                            </Tab.Group>
                                            : children
                                    }
                                </div>

                                {reloadWhenWizardFinish.current && (
                                    <span className="hidden xl:block absolute bottom-0 right-0 p-4 text-sm text-alt-2">
                                        Yipnyap will reload after you finish
                                    </span>
                                )}

                                <div
                                    className="flex flex-col md:flex-row sticky bottom-0 items-center justify-center w-full border-t border-b-0 border-x-0 border-solid border-divider divide-x divide-y-0 divide-solid divide-neutral-300 dark:divide-neutral-700">
                                    <button
                                        type="button"
                                        className={`${theme.button} p-4 rounded-none`}
                                        onClick={closeModal}
                                    >
                                        Cancel
                                    </button>

                                    <button
                                        type="button"
                                        className={`${theme.buttonPrimary} p-4 rounded-none`}
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
    );
}
