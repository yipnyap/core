import React, {useEffect} from 'react'
import {
    createBrowserRouter,
} from "react-router-dom"
import {NGAlertCard} from "./components/NGAlertCard";
import {useHeading} from "../../providers/PageHeading.provider";
import Root from "./root";
import Profile from "./pages/profile";
import SettingsGeneral from "./pages/profile/pages/settings";
import Activity from "./pages/activity";
import YipnyapID from "./pages/id";

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
                path: '/home/',
                element: <Activity />,
            },
            {
                path: '/groups/:groupId/',
                element: <Activity />,
            },
            {
                path: '/settings/',
                element: <SettingsGeneral/>,
                children: [
                    {
                        path: '*',
                        element: <SettingsGeneral/>,
                    },
                ]
            },
            {
                path: '/:username',
                element: <Profile/>,
                children: [
                    {
                        path: '*',
                        element: <Profile/>,
                    }
                ]
            },
            {
                path: '/id',
                element: <YipnyapID/>,
                children: [
                    {
                        path: 'login',
                        element: <YipnyapID/>,
                    },
                    {
                        path: 'create',
                        element: <YipnyapID/>,
                    }
                ]
            }
        ]
    },
]);

export function Void({...props}) {
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
