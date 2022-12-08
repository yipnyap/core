import React, {useEffect} from 'react'
import ReactDOM from 'react-dom'
import {
    createBrowserRouter,
    RouterProvider,
} from "react-router-dom"
import {NGAlertCard} from "../../../../nextgen/components/NGAlertCard";
import {useHeading} from "../../../../providers/PageHeading.provider";
import Root from "../../../nextgen2/root";
// @ts-ignore
import ProfileSettingsScreen from '../../../legacy/settings/ProfileSettingsScreen.js';
import {Cog6ToothIcon, QuestionMarkCircleIcon} from "@heroicons/react/24/outline";
import Profile from "../../profile";

let audio = new Audio(`${yipnyap_constants.yipnyap_url}/src/sound/splat_ambience.mp3`);
let boing = new Audio(`${yipnyap_constants.yipnyap_url}/src/sound/WAAAAAAA.mp3`);
let sans = new Audio(`${yipnyap_constants.yipnyap_url}/src/sound/voice_sans.mp3`);

function playAudio() {
    document.getElementById("NGContentArea")?.classList.add("opacity-0");
    audio.play();
}

export const router = createBrowserRouter([
    {
        path: "/",
        element: <Root />,
        errorElement: <div className="w-screen h-screen flex justify-center items-center bg-default">
            <NGAlertCard body={
                <div>
                    <p>Something is broken with Yipnyap.</p>
                    <p className="text-default-alt">Try refreshing the page. Error info has been dumped into devtools</p>
                </div>
            } />
        </div>,
        children: [
            {
                path: "/settings/",
                element: <SettingsGeneral />,
            },
            {
                path: "/:username",
                element: <Profile />,
            }
        ]
    },
]);

function SettingsGeneral() {
    const [, setHeading] = useHeading();

    useEffect(() => {
        setHeading({
            heading: "Settings",
            padding: true,
            subNavigation: [
                {
                    name: 'General',
                    description: '',
                    href: '/settings/',
                    icon: Cog6ToothIcon,
                    current: location.pathname === '/settings/',
                },
                {
                    name: 'More',
                    description: 'Go to Legacy Settings',
                    href: `/${yipnyap_constants.currentUser.username}/settings`,
                    target: '_blank',
                    icon: QuestionMarkCircleIcon,
                    current: false,
                }
            ]
        })
    }, [location.pathname])

    return (
        <div className="p-6">
            <ProfileSettingsScreen />
        </div>
    )
}

function Void({...props}) {
    const [, setHeading] = useHeading();

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
        })
    }, [location.pathname])

    return (
        <div className={"w-full h-full p-6"}>
            <div className={"w-full h-full flex justify-center items-center justify-center items-center space-x-32 border border-dotted border-2 border-default rounded-lg"}>
                {/* Text on left, image on right */}
                <div className={"flex flex-col"}>
                    <span className={"font-bold text-default-alt"}>No {props.type || 'page'} currently selected.</span>
                    <span className={"text-sm text-default-alt"} onClick={playAudio}>Just you and the void.</span>
                </div>
                <div className={"flex"}>
                    <img src={`${yipnyap_constants.yipnyap_url}/img/illustrations/lost-boi.png`} className={"w-fit h-fit"} alt={"Illustration of a confused sabertooth-tiger floating on ice in the middle of the ocean"}/>
                </div>
            </div>
        </div>
    )
}

if (localStorage.getItem('waaaaaaEE') === '1') {
    addEventListener('click', (event) => {
        if (boing.paused) {
            boing.play();
        } else {
            boing.currentTime = 0
        }
    });
}

if (localStorage.getItem('sansEE') === '1') {
    addEventListener('keypress', (event) => {
        if (sans.paused) {
            sans.play();
        } else {
            sans.currentTime = 0
        }
    });
}
