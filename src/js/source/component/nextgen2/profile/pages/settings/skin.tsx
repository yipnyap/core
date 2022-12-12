import React, {useEffect} from 'react';
import {useHeading} from "../../../../../providers/PageHeading.provider";
import {useLocation} from "react-router-dom";

export default function SettingsSkin({...props}) {
    const [heading, setHeading] = useHeading();
    const location = useLocation();
    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
            navigator: heading?.navigator
        })
    }, [location.pathname])
    return (
        <>
        {/* Jumbo onboarding header with image on right */}
        <div className="relative bg-gradient-to-b from-neutral-200 dark:from-neutral-700 overflow-hidden p-8">
            <div className="mt-10 sm:mt-12">
                <div className="mx-auto max-w-7xl">
                    <div className="lg:grid lg:grid-cols-12 lg:gap-8 h-80">
                        <div className="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                            <h1>
                                <span className="block text-sm font-semibold uppercase tracking-wide text-secondary sm:text-base lg:text-sm xl:text-base">
                                    Beta
                                </span>
                                <span className="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl">
                                    <span className="block text-default">Customize your profile</span>
                                </span>
                            </h1>
                            <p className="mt-3 text-base text-alt-2 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                                Change the look and feel of your profile to match your personality.
                            </p>
                        </div>
                        <div className="mt-10 sm:mt-16 lg:mt-0 lg:col-span-6">
                            <div className="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                                <img
                                    className="w-full rounded-md shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none"
                                    src={`${yipnyap_constants.yipnyap_url}/img/illustrations/settings/catto-page.png`}
                                    alt=""
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </>
    )
}