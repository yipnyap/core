import {useHeading} from "@nextgen2/providers/PageHeading.provider";
import React, {useEffect, useRef, useState} from "react";
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
import {Navigate, NavLink} from "react-router-dom";
import {NGTabList, NGAlertCard, NGButton} from "../../components";
import {ExclamationTriangleIcon} from "@heroicons/react/24/solid";

export const FormInputTheming = {
    main: ['appearance-none', 'bg-default', 'text-default', 'block', 'w-full', 'px-3', 'py-2', 'border border-solid', 'border-neutral-300 dark:border-neutral-500',
        'rounded-default', 'shadow-sm', 'placeholder-gray-400', 'highlight-main', 'max-h-9', 'focus:outline-none', 'focus:ring-blue-500',
        'focus:border-blue-500', 'sm:text-sm'],
    button: ['w-full', 'inline-flex', 'justify-center', 'py-2', 'px-4', 'border border-solid', 'border-neutral-300 dark:border-neutral-500',
        'rounded-default', 'shadow-sm', 'bg-default', 'text-sm', 'font-medium', 'text-default',
        'hover:bg-gray-50 dark:hover:bg-neutral-700']
}

function classNames(...classes: (string | boolean)[]) {
    return classes.filter(Boolean).join(' ');
}

export default function Register() {
    let theme = buildClassObject(FormInputTheming)
    const [, setHeading] = useHeading();
    const [isLoading, setLoading] = useState(false)
    const [error, setError] = useState<string>();
    const [canUsePasskey, setCanUsePasskey] = useState(false);

    const registerCard = useRef<HTMLDivElement>(null);
    const form = useRef<HTMLFormElement>(null);

    useEffect(() => {
        // window.PublicKeyCredential && (setCanUsePasskey(true));
        setHeading({
            heading: null,
        })
    }, [setHeading])


    if (yipnyap_constants.currentUser?.display_name) {
        return <Navigate replace to={'/'}/>
    }

    const handleRegister = (event: any) => {
        event.preventDefault()

        if (isLoading) return;
        setLoading(true)

        if (event.target.password.value !== event.target.password_verify.value) {
            setLoading(false);
            handleLoginError({message: 'Passwords do not match'});
            return;
        }

        fetch('/api/v2/id/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                username: event.target.username.value,
                password: event.target.password.value,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                setLoading(false);

                if (!data.success) {
                    handleLoginError(data);
                } else {
                    window.location.href = '/';
                }
            })
            .catch(err => {
                handleLoginError(err);
            })
    }

    const handleLoginError = (err: any) => {
        setLoading(false);
        console.log('[LoginService] err during login', err);

        setError(err.message);

        registerCard.current?.classList.add('snapanim-shake');
        setTimeout(() => {
            registerCard.current?.classList.remove('snapanim-shake');
        }, 100);
    }

    return (
        <>
            <div className="flex flex-col py-12 sm:px-6 lg:px-8">
                <div className="sm:mx-auto sm:w-full sm:max-w-md">
                    <img
                        className="logo-image mx-auto h-12 w-auto rounded-default"
                        src={yipnyap_constants.logo_url}
                        alt="Yipnyap Logo"
                    />
                    <h2 className="mt-6 text-center text-3xl font-extrabold text-default">👋 Welcome to Yipnyap!</h2>
                    <p className="mt-2 text-center text-sm text-alt-2">
                        Already joined?{' '}
                        <NavLink to={'/id/login/'} className="font-medium text-blue-600 hover:text-blue-500">
                            Log back in
                        </NavLink>
                    </p>
                </div>

                <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    {error && (
                        <NGAlertCard body={error} className={'mb-8'}/>
                    )}
                    <div ref={registerCard} className="relative">
                        {/* Loading spinner overlay */}
                        {isLoading && (
                            <div
                                className="absolute inset-0 flex items-center z-10 bg-box rounded-default justify-center">
                                <img className="h-5 w-5 animate-spin dark:invert"
                                     src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
                                     alt="Process working spinner"/>
                            </div>
                        )}
                        {/* Register form */}
                        <form className="space-y-6" onSubmit={handleRegister}>
                            <div>
                                <label htmlFor="username" className="block text-sm font-medium leading-6 text-default">
                                    Login Username
                                    <p className="mt-1 text-xs leading-5 text-default-alt">
                                        Your first username is bound to you forever, but you can change your @handle anytime.
                                    </p>
                                </label>
                                <div className="mt-2">
                                    <div className="flex rounded-md bg-white/5 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:!ring-indigo-600 sm:max-w-md">
                                        <span className="flex select-none items-center pl-3 text-neutral-500 sm:text-sm">yipnyap.me/</span>
                                        <input
                                            type="text"
                                            name="username"
                                            id="username"
                                            autoComplete="username"
                                            className="no-legacy block flex-1 border-0 bg-transparent py-1.5 pl-1 text-default placeholder:text-neutral-400 focus:ring-0 sm:text-sm sm:leading-6"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label htmlFor="password" className="block text-sm font-medium leading-6 text-default">
                                    Password
                                </label>
                                <div className="mt-2">
                                    <div className="flex rounded-md bg-white/5 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:!ring-indigo-600 sm:max-w-md">
                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            autoComplete="password"
                                            className="no-legacy block flex-1 border-0 bg-transparent py-1.5 px-3 text-default placeholder:text-neutral-400 focus:ring-0 sm:text-sm sm:leading-6"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label htmlFor="password_verify" className="block text-sm font-medium leading-6 text-default">
                                    One more time, now
                                </label>
                                <div className="mt-2">
                                    <div className="flex rounded-md bg-white/5 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:!ring-indigo-600 sm:max-w-md">
                                        <input
                                            type="text"
                                            name="password_verify"
                                            id="password_verify"
                                            autoComplete="none"
                                            className="no-legacy block flex-1 border-0 bg-transparent py-1.5 px-3 text-default placeholder:text-neutral-400 focus:ring-0 sm:text-sm sm:leading-6"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div className="block text-sm font-medium leading-6 text-default">
                                You'll be able to complete your profile after signing up.
                                <p className="mt-1 text-xs leading-5 text-default-alt">
                                    Before your account goes live, you can set your avatar, header, @handle, and more.
                                </p>
                            </div>

                            <div>
                                <p className="text-xs leading-5 text-default-alt">
                                    By signing up, you agree to our <a href="/community-guidelines"
                                                                       className="text-blue-600 hover:text-blue-500">Guidelines</a> and <a
                                    href="/privacy" className="text-blue-600 hover:text-blue-500">Privacy Policy</a>.
                                </p>
                                <NGButton type="submit" variant="primary" className="mt-4 !w-full" disabled={isLoading}>
                                    Register
                                </NGButton>
                            </div>
                        </form>

                        {/* Other login options */}
                        {/*<div className="mt-6">*/}
                        {/*    <div className="relative">*/}
                        {/*        <div className="absolute inset-0 flex items-center">*/}
                        {/*            <div className="w-full border-t border-default" />*/}
                        {/*        </div>*/}
                        {/*        <div className="relative flex justify-center text-sm">*/}
                        {/*            <span className="px-2 bg-default text-alt-2">Or continue with Passkeys</span>*/}
                        {/*        </div>*/}
                        {/*    </div>*/}

                        {/*    <div className="mt-6 grid grid-cols-3 gap-3">*/}
                        {/*        <div>*/}
                        {/*            <a*/}
                        {/*                href="src/route/id/login#"*/}
                        {/*                className={`${theme.button}`}*/}
                        {/*            >*/}
                        {/*                <span className="sr-only">Sign in with Passkey</span>*/}
                        {/*                <KeyIcon className="w-5 h-5" />*/}
                        {/*            </a>*/}
                        {/*        </div>*/}
                        {/*        <span className="col-span-2 text-sm text-neutral-500 dark:text-neutral-400">Passkeys are a secure, passwordless login made by the FIDO alliance. {canUsePasskey && 'This may require an update on your system to use.'}</span>*/}
                        {/*    </div>*/}
                        {/*</div>*/}
                    </div>
                </div>
            </div>
        </>
    )
}
