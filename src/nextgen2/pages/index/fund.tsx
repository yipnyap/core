import {NGBody, NGButton} from '@nextgen2/components';
import React from 'react';

export default function Fund() {
    return (
        <NGBody>
            <div className="flex flex-col space-y-8">
                <div className="flex flex-col space-y-4">
                    <h1 className="text-2xl font-bold">
                        Help us pay for upkeep<br/>
                        <span className="text-sm text-default-alt">
                            ...and feed the dev.
                        </span>
                    </h1>
                    <p className="text-default-alt">
                        Yipnyap is a free service, but we still need to pay for
                        hosting and other expenses, which adds up to <i>a lot</i>.
                        If you like Yipnyap and want to help us keep it running,
                        please consider donating.
                    </p>
                    <div className="flex flex-row space-x-2">
                        <NGButton
                            onClick={() => {
                                window.open('https://work.yipnyap.me/I2', '_blank')
                            }}>
                            Donate via Workspace
                        </NGButton>
                        <NGButton
                            onClick={() => {
                                window.open('https://donate.stripe.com/6oE8zk5Omciy7D26oo', '_blank')
                            }}>
                            Donate via Stripe Checkout
                        </NGButton>
                    </div>
                </div>

                {/* Horizontal Split */}
                <hr className="border border-solid border-default w-full"/>

                {/* Ramen Profitable progress. Either "Nothing", "Barely", etc. */}
                <div className="flex flex-col space-y-4">
                    <div className="flex flex-row space-x-2">
                        <div className="flex flex-col space-y-2">
                            <h1 className="text-2xl font-bold underline underline-offset-4 decoration-wavy">
                                $7.50 (<span className="text-red-500">Full Loss</span>)
                            </h1>
                            <p className="text-default-alt">
                                Per month. Ramen Profitable needs AUD$400/month to
                                cover hosting (~USD$30 + AUD$115), plus other expenses
                                of the dev, like food and rent. These prices fluctuate
                                a lot.
                            </p>
                            <p className="text-default-alt">
                                The monthly income can change dramatically, based
                                on how many people donate, how much they donate,
                                and if they cancel their donations.
                            </p>
                        </div>
                    </div>
                </div>

                {/* Horizontal Split */}
                <hr className="border border-solid border-default w-full"/>

                {/* Donation points */}
                <div className="flex flex-col space-y-4">
                    {/* Yipnyap will be free, forever and always. */}
                    <div className="flex flex-row space-x-2">
                        <div className="flex flex-col space-y-2">
                            <h1 className="text-2xl font-bold">
                                F*#k paying for a service
                            </h1>
                            <p className="text-default-alt">
                                Yipnyap will always be free, and we will never
                                charge for any features, sell your data, use
                                your data for anything other than the service,
                                and we will never, ever ever use your data for
                                advertising, marketing, or professional or
                                personal gain.
                            </p>
                            <p className="text-default-alt">
                                Our goal is to provide a free service that lets
                                you connect with furries across the world, and
                                we will never charge for that, not even{' '}
                                <a className="text-blue-500" href="https://www.furaffinity.net/plus" target="_blank">
                                    whatever these guys are doing
                                </a>.
                            </p>
                        </div>
                    </div>

                    {/* Yipnyap stays up, even at a loss */}
                    <div className="flex flex-row space-x-2">
                        <div className="flex flex-col space-y-2">
                            <h1 className="text-2xl font-bold">
                                We'll keep Yipnyap up, even if it's a loss
                            </h1>
                            <p className="text-default-alt">
                                We're not in this for the money, and we're not
                                going to stop Yipnyap if we're losing money.
                                We're doing this because we want to provide a
                                free service that furries can use to connect
                                with each other, and we'll keep doing that
                                no matter what.
                            </p>
                        </div>
                    </div>

                    {/* Excess */}
                    <div className="flex flex-row space-x-2">
                        <div className="flex flex-col space-y-2">
                            <h1 className="text-2xl font-bold">
                                Excess to exceeding organisations
                            </h1>
                            <p className="text-default-alt">
                                When Yipnyap makes a successful profit, we'll use
                                it to improve Yipnyap, and any unusable excess after
                                splitting will be donated to a charity selected
                                by the community.
                            </p>
                        </div>
                    </div>
                </div>

                {/* Horizontal Split */}
                <hr className="border border-solid border-default w-full"/>

                <div className="grid md:grid-cols-2 gap-8">
                    {/* Stripe/Workspace */}
                    <div className="flex flex-col space-y-2">
                        <h1 className="text-2xl font-bold">
                            Donate via Stripe
                        </h1>
                        <p className="text-default-alt">
                            Donating via Stripe is the easiest way to help us out,
                            as we don't have to pay as much in fees. You can donate
                            any amount you want, and you can even set up a recurring
                            donation.
                        </p>
                        <p className="text-default-alt">
                            Donating via our Phorge instance, usually referred to
                            as "Workspace", is processed the same as Stripe, but
                            requires you to create an account on Workspace. This
                            is needed if you want to claim donor benefits. If you
                            don't want to create an account, you can use Stripe
                            Checkout instead.
                        </p>
                        <a href="https://climate.stripe.com/8YciFq" target="_blank" className="text-blue-500 text-sm">
                            We will contribute 1% of your purchase to removing CO₂
                            from the atmosphere.
                        </a>
                        <div className="flex flex-row space-x-2">
                            <NGButton
                                onClick={() => {
                                    window.open('https://work.yipnyap.me/I2', '_blank')
                                }}>
                                Donate via Workspace
                            </NGButton>
                            <NGButton
                                onClick={() => {
                                    window.open('https://donate.stripe.com/6oE8zk5Omciy7D26oo', '_blank')
                                }}>
                                Donate via Stripe Checkout
                            </NGButton>
                        </div>
                    </div>

                    {/* Paypal */}
                    <div className="flex flex-col space-y-2">
                        <h1 className="text-2xl font-bold">
                            Donate via PayPal
                        </h1>
                        <p className="text-default-alt">
                            Donating via PayPal is a bit more expensive for us,
                            but it's still a good way to help us out. You can donate
                            any amount you want, and you can even set up a recurring
                            donation.
                        </p>
                        <div className="flex flex-row space-x-2">
                            <NGButton
                                onClick={() => {
                                    window.open('https://paypal.me/wychefur', '_blank')
                                }}>
                                Donate via PayPal
                            </NGButton>
                        </div>
                    </div>

                    {/* Patreon */}
                    <div className="flex flex-col space-y-2">
                        <h1 className="text-2xl font-bold">
                            Donate via Patreon
                        </h1>
                        <p className="text-default-alt">
                            Donating via Patreon gives you the same benefits as
                            donating via Stripe, but you have to create an account
                            on Patreon. If you don't want to create an account,
                            you can use Stripe Checkout instead.
                        </p>
                        <p className="text-default-alt">
                            Sometimes, the perks we offer on Patreon aren't
                            automatically applied to your account. If you're
                            having trouble claiming your perks, please <a className="text-blue-500"
                                                                          href="https://work.yipnyap.me/maniphest/task/edit/form/default/">
                            create a task</a>.
                        </p>
                        <div className="flex flex-row space-x-2">
                            <NGButton
                                onClick={() => {
                                    window.open('https://patreon.com/yipnyap', '_blank')
                                }}>
                                Donate via Patreon
                            </NGButton>
                        </div>
                    </div>

                    {/* Ko-fi */}
                    <div className="flex flex-col space-y-2">
                        <h1 className="text-2xl font-bold">
                            Donate via Ko-fi
                        </h1>
                        <p className="text-default-alt">
                            Donating via Ko-fi uses Stripe and PayPal, however
                            you'll be donating to a different account. You can
                            donate any amount you want, and you can even set up
                            a recurring donation. If you want to claim donor
                            benefits, you'll have to use Stripe Checkout or
                            Patreon.
                        </p>
                        <div className="flex flex-row space-x-2">
                            <NGButton
                                onClick={() => {
                                    window.open('https://ko-fi.com/rekkisomo', '_blank')
                                }}>
                                Donate via Ko-fi
                            </NGButton>
                        </div>
                    </div>
                </div>
            </div>

            {/* Footer */}
            <div className="flex flex-col space-y-2">
                <hr className="border border-solid border-default w-full"/>
                <div className="flex flex-col space-y-2 md:w-1/2">
                    <p className="text-default-alt">
                        This page is made by the owner of Yipnyap,{' '}
                        <a className="text-blue-500" href="/rekkisomo">Rek</a>.
                    </p>
                    <p className="text-default-alt">
                        On behalf of the rest of the Yipnyap team, thank you.
                        <br/>
                        👨‍💻❤️ @ 🚋🦘
                    </p>
                </div>
            </div>
        </NGBody>
    )
}