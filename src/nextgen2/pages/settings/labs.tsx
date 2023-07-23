import React, {useState} from 'react';
import {NGCard, NGHeading} from '@nextgen2/components';

// Ready for pain?
import {Checkbox, FormControl, FormHelperText} from "@mui/joy";

export default function SettingsLabs() {
    const [useJoyNavigation, setUseJoyNavigation] = useState<boolean>(localStorage.getItem('JoyUINavigation') === 'true');
    const [allowWominjekaUsage, setAllowWominjekaUsage] = useState<boolean>(localStorage.getItem('AllowWominjekaUsage') === 'true');
    const [useNextgenHomefeed, setUseNextgenHomefeed] = useState<boolean>(localStorage.getItem('NextgenFeed') === 'true');

    function toggleUseJoyNavigation() {
        setUseJoyNavigation(!useJoyNavigation);

        localStorage.setItem('JoyUINavigation', (!useJoyNavigation).toString());
    }

    function toggleAllowWominjekaUsage() {
        setAllowWominjekaUsage(!allowWominjekaUsage);

        localStorage.setItem('AllowWominjekaUsage', (!allowWominjekaUsage).toString());
    }

    function toggleUseNextgenHomefeed() {
        setUseNextgenHomefeed(!useNextgenHomefeed);

        localStorage.setItem('NextgenHomefeed', (!useNextgenHomefeed).toString());
    }

    return (
        <div className="flex flex-col space-y-8">
            <div className="flex flex-col space-y-4">
                <div className="flex flex-row space-x-4 justify-center items-center">
                    <div className="flex-1 mr-auto space-y-4">
                        <NGHeading>Yipnyap Labs</NGHeading>
                        <p className="text-sm text-default-alt">
                            Yipnyap Labs is a place where you can try out new
                            features before they are released to the public.
                            You need to reload after toggling a feature.
                        </p>
                        <p className="text-sm text-tertiary">
                            This page itself is a Labs feature. Things may break
                            here even if you don't enable any Labs features.
                        </p>
                    </div>

                    <div className="max-w-md my-auto">
                        <img
                            src={`${yipnyap_constants.yipnyap_url}/img/illustrations/walking-out-of-cave.png`}
                            alt="Animals walking out of a cave while others look in fear header image" className="h-48"/>
                    </div>
                </div>
            </div>

            <div className="flex flex-col space-y-4">
                <NGCard title="UI3 - Standardisation of UI Components">
                    <div className="flex flex-col space-y-4">
                        <p className="text-sm text-default-alt">
                            UI3 is very much in the future. These are some tweaks
                            that we're considering. Do not report bugs for these,
                            we know they're broken. That's the point.
                        </p>
                        <p className="text-sm text-default-alt">
                            Yipnyap is built on Tailwind, using Nextgen which is
                            our own UI library. Tailwind, being just a CSS framework,
                            is extremely messy to standardise and work with in a
                            large application (copium). We're trying out multiple
                            methods to keep things consistent.
                        </p>
                        <FormControl>
                            <Checkbox checked={useJoyNavigation} onChange={toggleUseJoyNavigation} label="Use Yipnyap Ecosystem Navigation" />
                            <FormHelperText>
                                Standardised navigation for everything. Unsure if we'll keep this.
                            </FormHelperText>
                        </FormControl>
                    </div>
                </NGCard>

                <NGCard title="UI3 - Homefeed">
                    <div className="flex flex-col space-y-4">
                        <p className="text-sm text-default-alt">
                            This is a new homefeed that we're working on. This
                            will replace the current homefeed, and will be
                            a lot more customisable. <strong>this will enable
                            some components of UI3.</strong>
                        </p>

                        <FormControl>
                            <Checkbox checked={useNextgenHomefeed} onChange={toggleUseNextgenHomefeed} label="Use Experimental Homefeed" />
                        </FormControl>
                    </div>
                </NGCard>

                <NGCard title="Chat API & Websocket Preparation">
                    <div className="flex flex-col space-y-4">
                        <p className="text-sm text-default-alt">
                            It's happening! Oh god!

                            While it's not ready yet, toggling this will ensure
                            that you will immediately get early access to the
                            new chat system. This will be a huge change, and
                            will require a lot of work to get it ready for
                            general release.
                        </p>
                        <p className="text-sm text-default-alt">
                            This will enable a websocket connection to the
                            server, some new UI components, and some changes
                            to existing ones to support messaging.
                        </p>
                        <FormControl>
                            <Checkbox checked={allowWominjekaUsage} onChange={toggleAllowWominjekaUsage} label="Enter Waitlist for Chat API" />
                        </FormControl>
                    </div>
                </NGCard>
            </div>
        </div>
    );
}