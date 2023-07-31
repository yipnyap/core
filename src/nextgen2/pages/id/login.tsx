import {useHeading} from "@nextgen2/providers/PageHeading.provider";
import React, {useEffect, useRef, useState} from "react";
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
import {Navigate, NavLink} from "react-router-dom";
import {NGWizard, NGAlertCard, NGButton} from "../../components";

export const FormInputTheming = {
    main: ['appearance-none', 'bg-default', 'text-default', 'block', 'w-full', 'px-3', 'py-2', 'border border-solid', 'border-neutral-300 dark:border-neutral-500',
        'rounded-default', 'shadow-sm', 'placeholder-gray-400', 'highlight-main', 'max-h-9', 'focus:outline-none', 'focus:ring-blue-500',
        'focus:border-blue-500', 'sm:text-sm'],
    button: ['w-full', 'inline-flex', 'justify-center', 'py-2', 'px-4', 'border border-solid', 'border-neutral-300 dark:border-neutral-500',
        'rounded-default', 'shadow-sm', 'bg-default', 'text-sm', 'font-medium', 'text-default',
        'hover:bg-gray-50 dark:hover:bg-neutral-700']
}

export default function Login() {
    let theme = buildClassObject(FormInputTheming)
    const [, setHeading] = useHeading();
    const [isLoading, setLoading] = useState(false);
    const [error, setError] = useState<string>();
    const [canUsePasskey, setCanUsePasskey] = useState(false);
    const [telegramAuthDialogOpen, setTelegramAuthDialogOpen] = useState(false);
    const [telegramAuthCode, setTelegramAuthCode] = useState<string>('');

    const loginCard = useRef<HTMLDivElement>(null);
    const form = useRef<HTMLFormElement>(null);

    useEffect(() => {
        window.PublicKeyCredential && (setCanUsePasskey(true));
        setHeading({
            heading: null,
        })
    }, [setHeading])

    if (yipnyap_constants.currentUser?.display_name) {
        return <Navigate replace to={'/'}/>
    }

    const handleLogin = (event: any) => {
        event.preventDefault()

        if (isLoading) return;
        setLoading(true)

        fetch('/api/v2/id/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                username: event.target.username.value,
                password: event.target.password.value,
                remember: event.target.remember.checked,
                ...(telegramAuthCode && {otp: telegramAuthCode})
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
                handleLoginError({error: err.message});
            })
    }

    const handleLoginError = (err: any) => {
        setLoading(false);
        console.log('[LoginService] err during login', err);

        if (err.message.toLowerCase().startsWith('otp is required')) {
            setTelegramAuthDialogOpen(true);
            return;
        }

        setError(err.message);

        loginCard.current?.classList.add('snapanim-shake');
        setTimeout(() => {
            loginCard.current?.classList.remove('snapanim-shake');
        }, 100);
    }

    return (
        <>
            <NGWizard
                isOpen={telegramAuthDialogOpen}
                onChange={() => {
                    setTelegramAuthDialogOpen(false);
                    form.current?.dispatchEvent(new Event('submit', {cancelable: true, bubbles: true}))
                }}
                dontAnimate={true}
            >
                <div className="flex flex-col gap-4 max-w-lg">
                    <h2>Check your Telegram</h2>
                    <p className="text-sm text-alt-2">
                        We've sent you a message on Telegram. Please check your Telegram app and enter the code below.
                    </p>

                    <div className="max-w-2xl relative text-neutral-400 focus-within:text-neutral-500">
                        <label htmlFor="telegram-otp"
                               className="sr-only">
                            Telegram OTP
                        </label>
                        <div className="mt-1 relative rounded-default shadow-sm">
                            <input type="text" name="search" id="telegram-otp"
                                   className="highlight-main block w-full max-h-9"
                                   placeholder="123ABC456" value={telegramAuthCode}
                                   onChange={e => setTelegramAuthCode(e.target.value)}/>
                        </div>
                    </div>
                </div>
            </NGWizard>
            <div className="flex flex-col py-12 sm:px-6 lg:px-8">
                <div className="sm:mx-auto sm:w-full sm:max-w-md">
                    <img
                        className="logo-image mx-auto h-12 w-auto rounded-default"
                        src={yipnyap_constants.logo_url}
                        alt="Yipnyap Logo"
                    />
                    <h2 className="mt-6 text-center text-3xl font-extrabold text-default">👋 Welcome Back!</h2>
                    <p className="mt-2 text-center text-sm text-alt-2">
                        First time here?{' '}
                        <NavLink to={'/id/create/'} className="font-medium text-blue-600 hover:text-blue-500">
                            Create a Yipnyap profile
                        </NavLink>
                    </p>
                </div>

                <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    {error && (
                        <NGAlertCard body={error} className={'mb-8'}/>
                    )}
                    <div ref={loginCard} className="relative">
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
                        <form className="space-y-6" onSubmit={handleLogin}>
                            <div>
                                <label htmlFor="username" className="block text-sm font-medium leading-6 text-default">
                                    Login Username
                                    <p className="mt-1 text-xs leading-5 text-default-alt">
                                        This is your first username, not your display name or @handle.
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
                                {/* Remember Me checkbox & Forgot password */}
                                <div className="flex items-center justify-between">
                                    <div className="flex items-center">
                                        <input
                                            id="remember"
                                            name="remember"
                                            type="checkbox"
                                            className="h-4 w-4 text-indigo-600 ring-1 ring-inset ring-neutral-300 dark:ring-white/10 focus:ring-indigo-500 border-neutral-300 rounded"
                                        />
                                        <label htmlFor="remember" className="ml-2 block text-sm text-default">
                                            Remember me
                                        </label>
                                    </div>

                                    <div className="text-sm">
                                        <NavLink to={'/id/recovery/'} className="font-medium text-blue-600 hover:text-blue-500">
                                            Forgot your password?
                                        </NavLink>
                                    </div>
                                </div>
                                <NGButton type="submit" variant="primary" className="mt-4 !w-full" disabled={isLoading}>
                                    Login
                                </NGButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </>
    )
}
