/* Version Experimentation 2022.06 Pre Alpha, Stranger Onboarding with FurAffinity Roast
 * 2022.06pa-LABS_STRANGER_ONBOARDING_FA_ROAST
 */
import React from 'react';

import {MapIcon, ScaleIcon, BadgeCheckIcon, HandIcon} from '@heroicons/react/outline';

const features = [
    {
        name: 'Forever evolving',
        description:
            'We won\'t be stuck in 2022, either. We got tons of ideas, as well as constantly elvolving with current and future web standards. (Except you, ETH. Screw you.)',
        icon: MapIcon,
    },
    {
        name: 'Moderation that takes no s**t.',
        description:
            'Everyone deserves to feel safe online. Our Guidelines bans the weird, and our Moderation team takes no s**t from even s**ttier people.',
        icon: ScaleIcon,
    },
    {
        name: 'Verified Program for those who do great',
        description:
            'Are you making a safe space for everyone, or doing greater stuff? We got a program for you that gives access to a bunch of goodies and licenses 👀',
        icon: BadgeCheckIcon,
    },
];

export default function NoUserCTAActivity(props) {
    return (
        <>
            <div className="bg-indigo-600">
                <div className="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between flex-wrap">
                        <div className="w-0 flex-1 flex items-center">
            <span className="flex p-2 rounded-lg bg-indigo-800">
              <HandIcon className="h-6 w-6 text-white" aria-hidden="true"/>
            </span>
                            <p className="ml-3 font-medium text-white tracking-tight">
                                <span className="md:hidden">This is a guest pandered version of Yipnyap.</span>
                                <span className="hidden md:block"><b>Transparency Notice:</b> You're on a pandered version of Yipnyap, compared to signed in users.</span> {' '}
                                <span className="mt-1 hidden md:block">Viewing: 2022.06pa-LABS_STRANGER_ONBOARDING_FA_ROAST (Most recent: {`${yipnyap_constants.yipnyap_server_version}`})</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div className="relative overflow-hidden">
                <div className="hidden sm:block sm:absolute sm:inset-y-0" aria-hidden="true">
                    <div className="relative max-w-7xl mx-auto">
                        <svg
                            className="absolute left-full transform -translate-y-3/4 -translate-x-1/4 md:-translate-y-1/2 lg:-translate-x-1/2"
                            width={404}
                            height={784}
                            fill="none"
                            viewBox="0 0 404 784"
                        >
                            <defs>
                                <pattern
                                    id="5d0dd344-b041-4d26-bec4-8d33ea57ec9b"
                                    x={0}
                                    y={0}
                                    width={20}
                                    height={20}
                                    patternUnits="userSpaceOnUse"
                                >
                                    <rect x={0} y={0} width={4} height={4} className="text-gray-200"
                                          fill="currentColor"/>
                                </pattern>
                            </defs>
                            <rect width={404} height={784} fill="url(#5d0dd344-b041-4d26-bec4-8d33ea57ec9b)"/>
                        </svg>
                    </div>
                </div>

                {/* Heading */}
                <div className="mt-16 mx-auto max-w-7xl px-4 sm:mt-24">
                    <div className="text-center">
                        <h1 className="text-2xl tracking-tight font-extrabold text-primary sm:text-5xl md:text-6xl z-10">
                            <span className="block">Furries deserve a site that</span>{' '}
                            <span className="block">isn't stuck in 2005</span>
                        </h1>
                        <p className="mt-3 max-w-md mx-auto text-base text-alt sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                            There hasn't been a modern site that has ground work to make everyone safe, features that
                            included every hobby, and isn't a dating app. <b>17 years later, and that's finally a
                            thing.</b>
                        </p>
                    </div>
                </div>

                {/* Statistics */}
                <div className="pt-12 sm:pt-16">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="max-w-4xl mx-auto text-center">
                            <h2 className="text-3xl font-extrabold text-primary sm:text-4xl">
                                Yipnyap is a better way to socialise.
                            </h2>
                            <p className="mt-3 text-xl text-alt sm:mt-4">
                                It's everything the others aren't. Groups, bulk uploading, split friends and followers, and more down the line such as HTML-based Profiles.
                            </p>
                        </div>
                    </div>
                    <div className="mt-10 pb-12 bg-white sm:pb-16">
                        <div className="relative">
                            <div className="absolute inset-0 h-1/2 bg-body"/>
                            <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                <div className="max-w-4xl mx-auto">
                                    <dl className="rounded-lg bg-white shadow-lg sm:grid sm:grid-cols-3">
                                        <div
                                            className="flex flex-col border-b border-gray-100 p-6 text-center sm:border-0 sm:border-r">
                                            <dt className="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Posts</dt>
                                            <dd className="order-1 text-5xl font-extrabold text-indigo-600">{props.posts}</dd>
                                        </div>
                                        <div
                                            className="flex flex-col border-t border-b border-gray-100 p-6 text-center sm:border-0 sm:border-l sm:border-r">
                                            <dt className="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Users</dt>
                                            <dd className="order-1 text-5xl font-extrabold text-indigo-600">{props.users}</dd>
                                        </div>
                                        <div
                                            className="flex flex-col border-t border-gray-100 p-6 text-center sm:border-0 sm:border-l">
                                            <dt className="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">Groups</dt>
                                            <dd className="order-1 text-5xl font-extrabold text-indigo-600">{props.groups}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Features */}
                <div className="py-12 bg-box">
                    <div className="max-w-xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <h2 className="sr-only">A better way to socialise.</h2>
                        <dl className="space-y-10 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-8">
                            {features.map((feature) => (
                                <div key={feature.name}>
                                    <dt>
                                        <div
                                            className="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                            <feature.icon className="h-6 w-6" aria-hidden="true"/>
                                        </div>
                                        <p className="mt-5 text-lg leading-6 font-medium text-gray-900">{feature.name}</p>
                                    </dt>
                                    <dd className="mt-2 text-base text-gray-500">{feature.description}</dd>
                                </div>
                            ))}
                        </dl>
                    </div>
                </div>

                {/* CTA */}
                <div className="bg-body">
                    <div className="max-w-7xl mx-auto text-center py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                        <h2 className="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            <span className="block">Registration is open.</span>
                            <span
                                className="mt-3 block text-xl text-alt sm:mt-4">Visual learner? Just scroll down.</span>
                        </h2>
                        <div className="mt-8 flex justify-center">
                            <div className="inline-flex rounded-md shadow">
                                <a
                                    href="/id/create"
                                    className="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                                >
                                    Get started
                                </a>
                            </div>
                            <div className="ml-3 inline-flex">
                                <a
                                    href="/login"
                                    className="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
                                >
                                    Sign in
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </>
    );
}
