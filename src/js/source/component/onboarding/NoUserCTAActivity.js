/* Version Experimentation 2022.06 Pre Alpha, Stranger Onboarding with FurAffinity Roast
 * 2022.06pa-LABS_STRANGER_ONBOARDING_FA_ROAST
 */
import React from 'react';
import {CrawlText} from "../../community-ui/snapper-engine/CrawlText";

export default function NoUserCTAActivity() {
    return (
        <>
            {/*<div className="bg-indigo-600">*/}
            {/*    <div className="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">*/}
            {/*        <div className="flex items-center justify-between flex-wrap">*/}
            {/*            <div className="w-0 flex-1 flex items-center">*/}
            {/*<span className="flex p-2 rounded-lg bg-indigo-800">*/}
            {/*  <HandIcon className="h-6 w-6 text-white" aria-hidden="true"/>*/}
            {/*</span>*/}
            {/*                <p className="ml-3 font-medium text-white tracking-tight">*/}
            {/*                    <span className="md:hidden">This is a guest pandered version of Yipnyap.</span>*/}
            {/*                    <span className="hidden md:block"><b>Transparency Notice:</b> You're on a pandered version of Yipnyap, compared to signed in users.</span> {' '}*/}
            {/*                    <span className="mt-1 hidden md:block">Viewing: 2022.06pa-LABS_STRANGER_ONBOARDING_FA_ROAST (Most recent: {`${yipnyap_constants.yipnyap_server_version}`})</span>*/}
            {/*                </p>*/}
            {/*            </div>*/}
            {/*        </div>*/}
            {/*    </div>*/}
            {/*</div>*/}
            <div className="relative bg-body overflow-hidden mb-12">
                <div className="max-w-screen-xl lg:!pl-24 mx-auto">
                    <div
                        className="relative z-10 pb-8 bg-body sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32"
                    >
                        <svg
                            className="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-base transform translate-x-1/2"
                            fill="currentColor"
                            preserveAspectRatio="none"
                            viewBox="0 0 100 100"
                            style={{
                                color: 'var(--color-body)',
                            }}
                        >
                            <polygon points="50,0 100,0 50,100 0,100" />
                        </svg>

                        <div className="relative pt-6 px-4 sm:px-6 lg:px-8"></div>

                        <main className="mt-10 mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 pt-0">
                            <div className="sm:text-center lg:text-left">
                                <div className="hidden absolute lg:block" style={{
                                    top: '3rem',
                                    right: '12rem',
                                }}>
                                    <img
                                        alt=""
                                        className="w-12"
                                        src={yipnyap_constants.yipnyap_url + "/img/illustrations/onboarding/tagline-shock.png"}
                                    />
                                </div>
                                <p
                                    className="tracking-tight leading-10 font-bold sm:leading-none"
                                    style={{
                                        fontSize: '62px',
                                        whiteSpace: 'break-spaces',
                                    }}
                                >
                                    <CrawlText>
                                        This is a place ::break: ::c:indigo-500 where people meet
                                    </CrawlText>
                                </p>
                                <p
                                    className="mt-3 text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0"
                                    style={{
                                        whiteSpace: 'break-spaces',
                                    }}
                                >
                                    <CrawlText delay={300 + 50 * 7} fast={true}>
                                        There hasn't been a modern site that has ground work to make everyone safe,
                                        features that included every hobby, and isn't a dating app. ::bold: 17 years later, and
                                        that's finally a thing.
                                    </CrawlText>
                                </p>
                                <div
                                    className="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start"
                                >
                                    <div className="rounded-lg shadow">
                                        <a
                                            href="/register"
                                            className="ypsdk button-upgrade flex items-center justify-center !px-8 !py-3 !leading-6"
                                            color="primary"
                                        >
                                            Get started
                                        </a>
                                    </div>
                                    <div className="mt-3 sm:mt-0 sm:ml-3">
                                        <div className="rounded-lg shadow">
                                            <a
                                                href="https://discord.gg/wrCGpAB"
                                                target="_blank"
                                                className="ypsdk button-upgrade flex items-center justify-center !px-8 !py-3 !leading-6"
                                            >
                                                Join our Discord
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
                <div className="hidden absolute lg:block lg:inset-y-0 lg:right-0 lg:w-1/2">
                    <img
                        alt=""
                        className="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                        src={yipnyap_constants.yipnyap_url + "/img/banner/meetup.svg"}
                    />
                </div>
            </div>
        </>
    );
}
