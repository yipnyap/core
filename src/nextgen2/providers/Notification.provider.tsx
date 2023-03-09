import React, {createContext, Fragment, useCallback, useContext, useEffect, useState} from 'react';
import {Transition} from "@headlessui/react";
import {CheckCircleIcon, EllipsisHorizontalIcon, XMarkIcon} from "@heroicons/react/24/solid";
import {ExclamationTriangleIcon} from "@heroicons/react/20/solid";

// some reason the state doesn't update within the context. So we have to use a global variable
let notificationsCache: any[] = [];
export const NotificationContext = createContext([] as any[]);

export default function NotificationContextProvider({children}: { children: React.ReactNode }) {
    const [notifications, setNotifications] = useState<any[]>([]);

    const remove = (id: string): string | boolean => {
        console.log('removeNotification', id);
        notificationsCache = notificationsCache.filter((n) => n.id !== id);
        setNotifications(notificationsCache);
        return id;
    };

    const addNotification = (n: any): string | boolean => {
        // Check if title and description match an existing notification
        const existingNotification = notificationsCache.find((notification) => {
            return notification.title === n.title && notification.message === n.message;
        });

        // If it does, return the id of the existing notification
        if (existingNotification) return existingNotification.id;

        n.id = n.id || Math.random().toString(36).slice(2, 9);
        n.expire = n.expire || 5000;
        n.type = n.type || 'default';

        if (!n.icon) {
            switch (n.type) {
                case 'success':
                    n.icon = CheckCircleIcon;
                    n.color = 'green-400';
                    break;
                case 'error':
                    n.icon = XMarkIcon;
                    n.color = 'red-400';
                    break;
                case 'warning':
                    n.icon = ExclamationTriangleIcon;
                    n.color = 'yellow-400';
                    break;
                default:
                    n.icon = EllipsisHorizontalIcon;
                    n.color = 'default';
                    break;
            }
        }

        // play donk.ogg
        const audio = new Audio(`${yipnyap_constants.yipnyap_url}/src/sound/donk.ogg`);
        audio.play().then(() => {
            audio.remove();
        });

        notificationsCache.push(n);
        setNotifications(notificationsCache);
        return n.id;
    };

    const update = () => {
    };
    // const addNotification = useCallback(add, []);
    const removeNotification = useCallback(remove, []);

    return (
        <NotificationContext.Provider value={[notifications, addNotification, removeNotification]}>
            {children}
        </NotificationContext.Provider>
    );
}

export function NotificationContainer() {
    const [notifications] = useNotification();
    const [, setRerender] = useState(0);
    const [dontRerender] = useState(0);

    useEffect(() => {
        setInterval(() => {
            setRerender((prev) => prev + 1);
        }, 100);
    }, [dontRerender]);

    return (
        <div
            aria-live="assertive"
            className="fixed z-50 inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start"
        >
            <div className="w-full flex flex-col items-center space-y-4 sm:items-end">
                {notifications.map((n: {
                    id: any;
                    title: any;
                    message: any;
                    type: any;
                    icon: any;
                    color: any;
                    expire: any;
                    persistent: any;
                }, i: React.Key | null | undefined) => {
                    return (
                        <Notification
                            key={i}
                            id={n.id}
                            title={n.title}
                            message={n.message}
                            type={n.type}
                            icon={n.icon}
                            color={n.color}
                            expire={n.expire}
                            persistent={n.persistent}
                        />
                    );
                })}
            </div>
        </div>
    );
}

function Notification({...props}) {
    const [, , removeNotification] = useNotification();
    const [show, setShow] = useState(true);
    const [dontRerender] = useState(0);

    useEffect(() => {
        if (!props.persistent) {
            setTimeout(() => {
                setShow(false);

                setTimeout(() => {
                    removeNotification(props.id);
                }, 100);
            }, props.expire);
        }
    }, [dontRerender]);

    return (
        <Transition
            show={show}
            as={Fragment}
            enter="transform ease-out duration-300 transition"
            enterFrom="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enterTo="translate-y-0 opacity-100 sm:translate-x-0"
            leave="transition ease-in duration-100"
            leaveFrom="opacity-100"
            leaveTo="opacity-0"
        >
            <div
                className="max-w-sm w-full bg-box shadow-lg rounded-default pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div className="p-4">
                    <div className="flex items-start">
                        <div className="flex-shrink-0">
                            <props.icon className={`h-6 w-6 text-${props.color}`} aria-hidden="true"/>
                        </div>
                        <div className="ml-3 w-0 flex-1 pt-0.5">
                            <p className="text-sm font-medium">{props.title}</p>
                            {props.message && <p className="mt-1 text-sm text-gray-500">{props.message}</p>}
                        </div>
                        <div className="ml-4 flex-shrink-0 flex">
                            <button
                                className="rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                onClick={() => {
                                    removeNotification(props.id);
                                }}
                            >
                                <span className="sr-only">Close</span>
                                <XMarkIcon className="h-5 w-5" aria-hidden="true"/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    )
}

export function useNotification() {
    const context = useContext(NotificationContext);
    if (context === undefined) {
        throw new Error('useNotification must be used within a NotificationContextProvider');
    }
    return context;
}
