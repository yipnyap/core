import PageModerateIndex from '@nextgen2/pages/group/moderate';
import React, {useEffect} from 'react'
import {
    createBrowserRouter,
} from 'react-router-dom'
import {useHeading} from '@nextgen2/providers/PageHeading.provider';
import Root from './root';
import Profile from './pages/profile';
import SettingsGeneral from '@nextgen2/pages/settings';
import YipnyapID from './pages/id';
import {NGCard} from '@nextgen2/components';
import {Index} from './pages/index';
import GroupsIndex from '@nextgen2/pages/group';

let audio = new Audio(`${yipnyap_constants.yipnyap_url}/src/sound/splat_ambience.mp3`);
let boing = new Audio(`${yipnyap_constants.yipnyap_url}/src/sound/WAAAAAAA.mp3`);
let sans = new Audio(`${yipnyap_constants.yipnyap_url}/src/sound/voice_sans.mp3`);

function playAudio() {
    document.getElementById('NGContentArea')?.classList.add('opacity-0');
    audio.play();
}

export const router = createBrowserRouter([{
    path: '/',
    element: <Root/>,
    errorElement: <div className="w-screen h-screen flex justify-center items-center bg-default">
        <NGCard className="w-1/2 -inset-px border-2 !highlight-white/0"
                title={<img className="m-auto"
                            src={`${yipnyap_constants.yipnyap_url}/img/illustrations/onboarding/dummy-mascot.png`}
                            alt="Crocodile mascot falling"/>}>
            <div className="flex flex-col space-y-4">
                <h2>Whoops. Something unknown is broken.</h2>
                <p>
                    We're not sure what's wrong, as it happened in a part of the code that we didn't expect to
                    break.
                </p>
                <p>
                    If you want to help us fix this, please contact us on Discord with the logs from
                    your browser's console, typically accessible by pressing F12 or Ctrl+Shift+I, and then
                    clicking on the "Console" tab. If you're not sure how to do this, please contact us on
                    Discord and we'll help you out.
                </p>
            </div>
        </NGCard>
    </div>,
    children: [{
        index: true,
        element: <Index/>,
    }, {
        path: '/feed/',
        element: <Index/>,
    }, {
        path: '/notifications/',
        element: <Index/>,
    }, {
        path: '/groups/:groupId/',
        children: [{
            path: 'moderate/*',
            element: <PageModerateIndex/>,
        }, {
            path: '*',
            element: <GroupsIndex/>,
        }],
    }, {
        path: '/settings/*',
        element: <SettingsGeneral/>,
    }, {
        path: '/id/',
        element: <YipnyapID/>,
        children: [{
            path: 'login',
            element: <YipnyapID/>,
        }, {
            path: 'create',
            element: <YipnyapID/>,
        }, {
            path: 'recovery',
            element: <YipnyapID/>,
        }],
    }, {
        path: '/:username',
        element: <Profile/>,
        children: [{
            path: '*',
            element: <Profile/>,
        }],
    }],
}]);

export function Void({...props}) {
    const [, setHeading] = useHeading();

    useEffect(() => {
        setHeading({
            heading: null,
            padding: false,
        })
    }, [location.pathname])

    return (
        <div className={'w-full h-full p-6'}>
            <div
                className={'w-full h-full flex justify-center items-center space-x-32 border-dotted border-2 border-default rounded-lg'}>
                {/* Text on left, image on right */}
                <div className={'flex flex-col'}>
                    <span className={'font-bold text-default-alt'}>No {props.type || 'page'} currently selected.</span>
                    <span className={'text-sm text-default-alt'} onClick={playAudio}>Just you and the void.</span>
                </div>
                <div className={'flex'}>
                    <img src={`${yipnyap_constants.yipnyap_url}/img/illustrations/lost-boi.png`}
                         className={'w-fit h-fit'}
                         alt={'Illustration of a confused sabertooth-tiger floating on ice in the middle of the ocean'}/>
                </div>
            </div>
        </div>
    )
}

if (localStorage.getItem('waaaaaaEE') === '1') {
    addEventListener('click', () => {
        if (boing.paused) {
            boing.play();
        } else {
            boing.currentTime = 0
        }
    });
}

if (localStorage.getItem('sansEE') === '1') {
    addEventListener('keypress', () => {
        if (sans.paused) {
            sans.play();
        } else {
            sans.currentTime = 0
        }
    });
}
