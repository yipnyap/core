import React from 'react';
import {Fragment, useRef, useState} from 'react';

import IconSVG from '../icon/IconSVG';
import {Dialog, Transition} from "@headlessui/react";
import {ExclamationIcon} from "@heroicons/react/outline";

function MessageBox(props) {
    const [open, setOpen] = useState(true);

    const cancelButtonRef = useRef(null);

    let iconColor = 'secondary',
        iconType = 'info';

    if (props.success) {
        iconColor = 'primary';
        iconType = 'success';
    } else if (props.error) {
        iconColor = 'tertiary';
        iconType = 'error';
    } else if (props.warning) {
        iconColor = 'tertiary';
    }

    /*
    props = {
        success: boolean,
        error: boolean,
        warning: boolean,
        forwardedRef: Ref,
        confirm: boolean,
        continue: boolean,
        data: {
            title: string,
            text: string,
        },
        onCancel: Function,
        onAccept: Function,
        onContinue: Function
     */

    return (
        <div ref={props.forwardedRef}>
            <div

                className="inline-block align-bottom bg-box rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div className="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div className="sm:flex sm:items-start">
                        <div
                            className="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <ExclamationIcon className="h-6 w-6 text-red-600" aria-hidden="true"/>
                        </div>
                        <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 className="text-lg leading-6 font-medium">
                                {props.data.title}
                            </h3>
                            <div className="mt-2">
                                <p className="text-sm text-gray-500">
                                    {props.data.text}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {
                    props.confirm &&
                    <div className="bg-box-alt px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            className="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                            onClick={props.onAccept}
                        >
                            {yipnyap_translation.accept}
                        </button>
                        <button
                            type="button"
                            className="mt-3 w-full inline-flex justify-center rounded-md border border-primary shadow-sm px-4 py-2 bg-box-over text-base font-medium text-primary hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            onClick={props.onCancel}
                            ref={cancelButtonRef}
                        >
                            {yipnyap_translation.cancel}
                        </button>
                    </div>
                }

                {
                    props.continue &&
                    <div className="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            className="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                            onClick={props.onContinue}
                        >
                            {yipnyap_translation.continue}
                        </button>
                    </div>
                }
            </div>

        </div>
    );
}

export {MessageBox as default};
