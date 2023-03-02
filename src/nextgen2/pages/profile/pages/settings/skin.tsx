import React, {FormEventHandler, useEffect, useState} from 'react';
import {useHeading} from "@legacy/providers/PageHeading.provider";
import {useLocation} from "react-router-dom";
import {NGAlertCard} from "../../../../components/NGAlertCard";
import {RadioGroup} from "@headlessui/react";
import {CheckIcon, QuestionMarkCircleIcon} from "@heroicons/react/24/solid";
import {NGCard} from "@nextgen2/components";
import {useTheme} from "@legacy/providers/contexts";

const globalVariants = [
    {
        name: 'Light',
    },
    {
        name: 'Dark',
    },
    {
        name: 'System',
    }
]

export default function SettingsSkin({...props}) {
    const [heading, setHeading] = useHeading();
    const location = useLocation();
    const [theme, setTheme] = useTheme();

    const [selectedGlobalVariant, setSelectedGlobalVariant] = useState(globalVariants.find((variant) => variant.name.toLowerCase() === theme.variant) || globalVariants[0]);

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
            navigator: heading?.navigator
        })
    }, [location.pathname])

    function doGlobalVariantChange(value: any) {
        const variant = value || {name: 'System'};
        setSelectedGlobalVariant(variant);
        setTheme({variant: variant.name.toLowerCase()});
        localStorage.setItem('theme', variant.name.toLowerCase());
    }

    return (
        <>
            {/* Jumbo onboarding header with image on right */}
            <div className="relative bg-gradient-to-b from-neutral-200 dark:from-neutral-700 overflow-hidden p-8">
                <div className="mt-10 sm:mt-12">
                    <div className="mx-auto max-w-7xl">
                        <div className="lg:grid lg:grid-cols-12 lg:gap-8 h-80">
                            <div className="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                                <h1>
                                <span
                                    className="block text-sm font-semibold uppercase tracking-wide text-secondary sm:text-base lg:text-sm xl:text-base">
                                    Beta
                                </span>
                                    <span
                                        className="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl">
                                    <span className="block text-default">Customize Yipnyap</span>
                                </span>
                                </h1>
                                <p className="mt-3 text-base text-alt-2 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                                    Yipnyap is yours to customise. Your profile skin is visible to you everywhere, and
                                    to
                                    anyone who's on your profile.
                                </p>
                            </div>
                            <div className="mt-10 sm:mt-16 lg:mt-0 lg:col-span-6">
                                <div className="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                                    <img
                                        className="w-full rounded-md shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none"
                                        src={`${yipnyap_constants.yipnyap_url}/img/illustrations/settings/skin-example.png`}
                                        alt=""
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Body content with padding */}
            <div
                className="flex flex-col justify-center items-center w-3/5 mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-4">
                <NGCard title="Skin drafts are saved on device">
                    <p className="text-default-alt">
                        When you want to customise a skin that isn't the one currently active, you'll need to do it
                        on
                        the device & browser you created it, or the device & browser you last modified it on.
                    </p>
                </NGCard>

                {/* Skin selector */}
                <NGCard title="Global Variant">
                    <div
                        className="flex flex-col">
                        <p className="text-sm text-alt-2 mb-2">
                            This modifies the theme shown to you everywhere, not to anyone else. It's stacked on top of
                            your
                            profile skin.
                        </p>
                        <fieldset>
                            <legend className="text-sm font-medium text-default">Variant</legend>
                            <div className="mt-2 space-y-5">
                                <RadioGroup value={selectedGlobalVariant} onChange={doGlobalVariantChange}>
                                    <RadioGroup.Label className="sr-only">Server size</RadioGroup.Label>
                                    <div className="space-y-2">
                                        {globalVariants.map((option) => (
                                            <RadioGroup.Option
                                                key={option.name}
                                                value={option}
                                                className={({active, checked}) =>
                                                    `${active
                                                        ? 'ring-2 ring-white ring-opacity-60 ring-offset-2 ring-offset-sky-300'
                                                        : ''}
                                                     ${checked ? 'bg-default-alt bg-opacity-75 text-default' : 'bg-default dark:bg-transparent'}
                                                     relative flex cursor-pointer rounded-lg px-5 py-4 border border-default focus:outline-none hover:bg-neutral-200 dark:hover:bg-neutral-700 hover:bg-opacity-75`
                                                }
                                            >
                                                {({active, checked}) => (
                                                    <>
                                                        <div className="flex w-full items-center justify-between">
                                                            <div className="flex items-center">
                                                                <div className="text-sm">
                                                                    <RadioGroup.Label
                                                                        as="p"
                                                                        className={`font-medium  ${
                                                                            checked ? 'text-default' : 'text-default-alt'
                                                                        }`}
                                                                    >
                                                                        {option.name}
                                                                    </RadioGroup.Label>
                                                                </div>
                                                            </div>
                                                            {checked && (
                                                                <div className="shrink-0 text-default">
                                                                    <CheckIcon className="h-6 w-6"/>
                                                                </div>
                                                            )}
                                                        </div>
                                                    </>
                                                )}
                                            </RadioGroup.Option>
                                        ))}
                                    </div>
                                </RadioGroup>
                            </div>
                        </fieldset>
                    </div>
                </NGCard>
            </div>
        </>
    )
}