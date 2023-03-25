/**
 * Page that shows a Progress Bar that shows how much storage is used in either MB, or GB.
 */
import {NGTable} from '@nextgen2/components';
import React, {useEffect, useState} from 'react';

export default function SettingsStorage() {
    const [usedBytes, setUsedBytes] = useState(0);
    const [maxBytes, setMaxBytes] = useState(0);
    const [usedHumanReadable, setUsedHumanReadable] = useState('0B');
    const [maxHumanReadable, setMaxHumanReadable] = useState('0B');
    const [culpritFiles, setCulpritFiles] = useState<{
        name: string; path: string; size: {
            bytes: number; human: string;
        }
    }[]>([]);

    // Get the user's storage usage
    useEffect(() => {
        // Get the user's storage usage
        fetch('/api/v2/storage/', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
            },
        }).then(async (response) => {
            const data = await response.json();
            if (response.status === 200) {
                setUsedBytes(data.usage.bytes);
                setUsedHumanReadable(data.usage.human);

                setMaxBytes(data.max.bytes);
                setMaxHumanReadable(data.max.human);

                setCulpritFiles(data.files);
            } else {
                console.error(data);
            }
        }).catch((error) => {
            console.error(error);
        });
    }, []);

    let userStorageUsedPercentage = (
        usedBytes / maxBytes
    ) * 100;
    let userStorageOverbleed = 0;

    // Usage overbleed
    if (userStorageUsedPercentage > 100) {
        userStorageOverbleed = userStorageUsedPercentage - 100;
        userStorageUsedPercentage = 100;
    }

    // Animate the progress bar upwards ticker style
    const [userStorageUsedPercentageState, setUserStorageUsedPercentageState] = useState(0);
    const [userStorageOverbleedState, setUserStorageOverbleedState] = useState(0);
    if (userStorageUsedPercentageState < userStorageUsedPercentage) {
        setTimeout(() => {
            setUserStorageUsedPercentageState(userStorageUsedPercentageState + 1);
        }, 1);
    } else if (userStorageOverbleedState < userStorageOverbleed) {
        setTimeout(() => {
            setUserStorageOverbleedState(userStorageOverbleedState + 1);
        }, 1);
    }

    function makeHumanReadable(bytes: number) {
        if (bytes >= 1000000000) {
            return `${bytes / 1000000000}GB`;
        } else if (bytes >= 1000000) {
            return `${bytes / 1000000}MB`;
        } else if (bytes >= 1000) {
            return `${bytes / 1000}KB`;
        } else {
            return `${bytes}B`;
        }
    }

    return (
        <div className="flex flex-col space-y-8">
            <div className="flex flex-col space-y-4">
                <h1 className="text-2xl font-bold">Allocated Storage</h1>
                <div className="space-y-2">
                    <p className="text-default-alt">
                        This is the amount of storage you have allocated to your account. Some users
                        may have more storage than others. If you need more storage, please <a
                        href="https://work.yipnyap.me/">
                        create a task</a>.
                    </p>
                    <p className="text-default-alt">
                        This storage is used for your images, videos, certain profile data, and other files. It is not
                        used for
                        own personal storage.
                    </p>
                </div>
            </div>

            {/* Progress Bar that shows how much storage is used in either MB, or GB. Caps at 15GB. */}
            <div className="flex flex-col h-full">
                <div className="w-full">
                    <div className="relative pt-1">
                        <div className="flex mb-2 items-center">
                            {userStorageOverbleedState > 0 && (
                                <div className="mr-2 md:!mr-0 z-10 static md:absolute" style={{
                                    ...(
                                        userStorageOverbleedState < 90 ? {
                                            left: `${userStorageOverbleedState - 5}%`,
                                        } : {right: '-5px'}
                                    ),
                                }}>
                                    <span
                                        className="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200 dark:bg-red-500 dark:text-red-50">
                                        {userStorageOverbleedState}% Over
                                    </span>
                                </div>
                            )}
                            <div className="flex-grow z-10 static md:absolute" style={{
                                ...(
                                    userStorageUsedPercentageState <= 95 ? {
                                        left: `${userStorageUsedPercentageState - (
                                            userStorageUsedPercentageState > 15 ? 5 : userStorageUsedPercentageState
                                        )}%`,
                                    } : {right: '-5px'}
                                ), ...(
                                    userStorageOverbleedState >= 90 ? {left: '0'} : {}
                                ),
                            }}>
                                <span
                                    className="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200 dark:bg-blue-500 dark:text-blue-50">
                                    {usedHumanReadable}
                                </span>
                            </div>
                            <div className="static md:absolute right-0 text-right">
                                <span className="text-xs font-semibold inline-block text-blue-600 dark:text-blue-50">
                                    {maxHumanReadable}
                                </span>
                            </div>
                        </div>
                        <div
                            className="overflow-hidden h-2 mb-4 md:mt-5 text-xs flex rounded bg-blue-200 dark:bg-neutral-700">
                            {userStorageOverbleedState > 0 && (
                                <div
                                    style={{
                                        width: `${userStorageOverbleedState}%`,
                                    }}
                                    className="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"/>
                            )}
                            <div
                                style={{width: `${userStorageUsedPercentageState - userStorageOverbleedState}%`}}
                                className="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"/>
                        </div>
                    </div>
                </div>
            </div>

            {/* Over storage quota notice */}
            {userStorageOverbleed > 0 && (
                <div className="flex flex-col space-y-4">
                    <h1 className="text-2xl font-bold text-red-500">{userStorageOverbleedState}% Over Storage Quota</h1>
                    <p className="text-default-alt">
                        You are currently {userStorageOverbleedState}% over your storage quota. Deleting some posts or
                        files
                        will free up space. If you don't delete anything, you may soon lose access to features that
                        require storage.
                    </p>
                </div>
            )}

            {/* List of files that are taking up the most space */}
            <div className="flex flex-col space-y-4">
                <h1 className="text-2xl font-bold">Culprit Files</h1>
                <NGTable headers={['Name', 'Size']} data={culpritFiles.map((file) => {
                    return [() => (
                        <div className="flex flex-col space-y-2">
                            <span className="text-default-alt">
                                {file.name}
                            </span>
                            {file.path && (
                                <span className="text-default-alt text-xs">
                                    {file.path}
                                </span>
                            )}
                        </div>
                    ), file.size.human];
                })}/>
            </div>
        </div>
    );
}