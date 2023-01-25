import {useHeading} from "../../../../providers/PageHeading.provider";
import React, {useEffect, useRef, useState} from "react";
import {buildClassObject} from "../../utils/ColourScheme.utils";
import {Navigate, NavLink} from "react-router-dom";
import {NGWizard, NGAlertCard} from "../../components";

export const FormInputTheming = {
    main: ['appearance-none', 'bg-default', 'text-default', 'block', 'w-full', 'px-3', 'py-2', 'border border-solid', 'border-neutral-300 dark:border-neutral-500',
        'rounded-default', 'shadow-sm', 'placeholder-gray-400', 'highlight-main', 'max-h-9', 'focus:outline-none', 'focus:ring-blue-500',
        'focus:border-blue-500', 'sm:text-sm'],
    button: ['w-full', 'inline-flex', 'justify-center', 'py-2', 'px-4', 'border border-solid', 'border-neutral-300 dark:border-neutral-500',
        'rounded-default', 'shadow-sm', 'bg-default', 'text-sm', 'font-medium', 'text-default',
        'hover:bg-gray-50 dark:hover:bg-neutral-700']
}

export default function Recovery() {
    let theme = buildClassObject(FormInputTheming)
    const [, setHeading] = useHeading();
    const [isLoading, setLoading] = useState(false);
    const [error, setError] = useState<string>();
    const [telegramAuthDialogOpen, setTelegramAuthDialogOpen] = useState(false);
    const [telegramAuthCode, setTelegramAuthCode] = useState<string>('');

    // 0 = ask for password, 1 = ask for otp
    const [passwordResetStep, setPasswordResetStep] = useState(0);
    const [newPassword, setNewPassword] = useState<string>('');

    const loginCard = useRef<HTMLDivElement>(null);
    const form = useRef<HTMLFormElement>(null);

    useEffect(() => {
        setHeading({
            heading: null,
        })
    }, [setHeading])

    if (yipnyap_constants.currentUser?.display_name) {
        return <Navigate replace to={'/home/'}/>
    }

    const handleRecovery = (event: any) => {
        event.preventDefault()

        if (isLoading) return;
        setLoading(true)

        if (passwordResetStep === 0 && !newPassword) {
            setLoading(false);
            setTelegramAuthDialogOpen(true);
            return;
        }

        fetch('/api/v2/id/recover', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                username: event.target.username.value,
                ...(newPassword && {password: newPassword}),
                ...(telegramAuthCode && {otp: telegramAuthCode})
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                setLoading(false);

                if (!data.success) {
                    handleRecoveryError(data);
                } else {
                    window.location.href = '/id/login';
                }
            })
            .catch(err => {
                handleRecoveryError({error: err.message});
            })
    }

    const handleRecoveryError = (err: any) => {
        setLoading(false);
        console.log('[LoginService] err during recovery', err);

        if (err.message.toLowerCase().startsWith('otp is required')) {
            setTelegramAuthDialogOpen(true);
            setPasswordResetStep(1);
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
                isTertiary={true}
            >
                <div className="flex flex-col gap-4 max-w-lg">
                    {passwordResetStep === 0 && (
                        <>
                            <h2>You're about to initiate a recovery</h2>
                            <p className="text-sm text-alt-2">
                                Data stored in your secure vault (the vault that requires 2FA to access) will be wiped,
                                and you will be logged out of all devices. If you have data stored in your vault that
                                you do not have a backup of, you will lose it.
                                <br/><br/>
                                If you have your Secure ID Level set to {">="} 2, you can only do this recovery 3 times
                                every month. If you have your Secure ID Level set to {">="} 3, you can only do this
                                recovery 1 time every 3 months. Support staff cannot override this limit.
                                <br/><br/>
                                If you are sure you want to continue, please enter a password, then click continue.
                            </p>

                            <div className="max-w-2xl relative text-neutral-400 focus-within:text-neutral-500">
                                <label htmlFor="password"
                                       className="sr-only">
                                    Password
                                </label>
                                <div className="mt-1 relative rounded-default shadow-sm">
                                    <input type="password" name="password" id="password"
                                           className="highlight-main block w-full max-h-9"
                                           placeholder="New Password" value={newPassword}
                                           onChange={e => setNewPassword(e.target.value)}/>
                                </div>
                            </div>
                        </>
                    )}

                    {passwordResetStep === 1 && (
                        <>
                            <h2>Enter the sent code</h2>
                            <p className="text-sm text-alt-2">
                                You need to enter the code that was sent to you via Telegram.
                                <br/><br/>
                                If you're trying to hack into this account, congratulations! You
                                have just semi-doxxed yourself to the owner of this account.
                                Please stop.
                            </p>
                            <div className="max-w-2xl relative text-neutral-400 focus-within:text-neutral-500">
                                <label htmlFor="telegram-otp"
                                       className="sr-only">
                                    Telegram OTP
                                </label>
                                <div className="mt-1 relative rounded-default shadow-sm">
                                    <input type="text" name="telegram-otp" id="telegram-otp"
                                           className="highlight-main block w-full max-h-9"
                                           placeholder="123ABC456" value={telegramAuthCode}
                                           onChange={e => setTelegramAuthCode(e.target.value)}/>
                                </div>
                            </div>
                        </>
                    )}
                </div>
            </NGWizard>
            <div className="flex flex-col py-12 sm:px-6 lg:px-8">
                <div className="sm:mx-auto sm:w-full sm:max-w-md">
                    <div className="flex flex-row space-x-4 justify-center items-center">
                        <div className="flex-1 mr-auto">
                            <h2 className="text-2xl font-bold">Account Recovery</h2>
                        </div>

                        <div className="max-w-md my-auto">
                            <img
                                src={`${yipnyap_constants.yipnyap_url}/img/illustrations/lost-boi.png`}
                                alt="Telegram header image" className="h-48"/>
                        </div>
                    </div>
                </div>

                <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                    {error && (
                        <NGAlertCard body={error} className={'mb-8'}/>
                    )}
                    <div ref={loginCard} className="relative bg-default py-8 px-4 shadow rounded-xl sm:px-10">
                        {/* Loading spinner overlay */}
                        {isLoading && (
                            <div
                                className="absolute inset-0 flex items-center z-10 bg-box rounded-default justify-center">
                                <img className="h-5 w-5 animate-spin dark:invert"
                                     src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
                                     alt="Process working spinner"/>
                            </div>
                        )}
                        {/* Recovery form */}
                        <form ref={form} className="space-y-6" onSubmit={handleRecovery}>
                            <div>
                                <label htmlFor="username" className="block text-sm font-medium text-alt-2">
                                    Username
                                    <p className="text-xs font-normal text-alt-2">
                                        If you've lost this, you'll need to contact us instead.
                                        Try searching around Yipnyap, or if you have a Telegram account
                                        linked, you can check the message history you have with Yipnyap.
                                    </p>
                                </label>
                                <div className="mt-1">
                                    <input
                                        id="username"
                                        name="username"
                                        type="username"
                                        autoComplete="username"
                                        required
                                        className={`${theme.main}`}
                                    />
                                </div>
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    className="w-full flex justify-center py-2 px-4 border border-transparent rounded-default shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Begin Recovery
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </>
    )
}
