import React, {Fragment, useEffect, useRef, useState} from "react";
import {Dialog, Tab, Transition} from "@headlessui/react";
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
import {ButtonTheming} from "@nextgen2/pages/settings/telegram";

export default function NGWizard(props: {
    theme?: any;
    isOpen?: any;
    dontAnimate?: boolean;
    onClose?: any;
    onChange: Function;
    isTertiary?: boolean;
    children: JSX.Element;
}) {
    const theme = props.theme || buildClassObject(ButtonTheming, 'neutral');
    const [isOpen, setIsOpen] = useState(props.isOpen || false);

    /**
     * This is an attempt at using GNOME Human Interface Guidelines & Adwaita styling. Testing the waters.
     * See https://developer.gnome.org/hig/
     */

    const dialog = useRef<HTMLDivElement>(null);
    const dialogInner = useRef<HTMLDivElement>(null);

    function closeModal() {
        if (props.onClose) {
            props.onClose();
        } else {
            setIsOpen(false);
        }
    }

    requestAnimationFrame(() => {
        if (!props.dontAnimate && dialog.current && dialogInner.current) {
            dialog.current.style.width = `${dialogInner.current.scrollWidth}px`;
            dialog.current.style.height = `${dialog.current.offsetHeight}px`;
        }
    })

    useEffect(() => {
        setIsOpen(props.isOpen);
    }, [props.isOpen])

    return (
        <Transition appear show={isOpen} as={Fragment}>
            <Dialog as="div" className="relative" style={{zIndex: '900'}} onClose={closeModal}>
                <Transition.Child
                    key={props.isOpen}
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
                            key={props.isOpen}
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
                                className={`${props.isTertiary ? '!bg-opacity-50 bg-red-100 dark:bg-red-900' : ''} max-w-md max-w-full min-h-sm max-h-full m-auto flex flex-col bg-box transform overflow-hidden rounded-2xl text-left align-middle shadow-xl transition-all border border-solid border-divider`}
                            >
                                <div ref={dialogInner} className="w-fit h-fit p-12 flex-1 overflow-auto">
                                    {props.children}
                                </div>

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
                                        onClick={() => props.onChange()}
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
