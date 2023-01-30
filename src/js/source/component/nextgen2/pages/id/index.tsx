import React, {useEffect} from "react";
import {useLocation} from "react-router-dom";
import {
    ClipboardDocumentListIcon,
    KeyIcon, LifebuoyIcon, ShieldCheckIcon,
    UserPlusIcon,
} from "@heroicons/react/24/outline";
import {useHeading} from "../../../../providers/PageHeading.provider";
import {Void} from "../..";
import Login from "./login";
import Register from "./create";
import Recovery from "./recovery";
import {ArrowUpRightIcon} from "@heroicons/react/20/solid";

export default function YipnyapID() {
    const [heading, setHeading] = useHeading();
    const location = useLocation();

    useEffect(() => {
        setHeading({
            heading: null,
            padding: true,
            navigator: {
                subNavigation: [
                    {
                        name: 'Login',
                        description: '',
                        href: '/id/login',
                        icon: KeyIcon,
                        current: location.pathname === '/id/login',
                    },
                    {
                        name: 'Register',
                        description: '',
                        href: '/id/create',
                        icon: UserPlusIcon,
                        current: location.pathname === '/id/create',
                    },
                    {
                        name: 'Account Recovery',
                        description: '',
                        href: '/id/recovery',
                        icon: LifebuoyIcon,
                        current: location.pathname === '/id/recovery',
                    },
                    {
                        name: <span className='inline-flex'>Privacy <ArrowUpRightIcon className='w-4'/></span>,
                        description: '',
                        href: '/privacy',
                        icon: ShieldCheckIcon,
                        target: '_blank',
                        current: location.pathname === '/privacy',
                    },
                    {
                        name: <span className='inline-flex'>Guidelines <ArrowUpRightIcon className='w-4'/></span>,
                        description: '',
                        href: '/community-guidelines',
                        icon: ClipboardDocumentListIcon,
                        target: '_blank',
                        current: location.pathname === '/community-guidelines',
                    }
                ]
            }
        })
    }, [location.pathname])

    return (
        <>
            {!heading?.navigator?.subNavigation?.find((item) => item.current) && <Void/>}
            {location.pathname === '/id/login' && <Login/>}
            {location.pathname === '/id/create' && <Register/>}
            {location.pathname === '/id/recovery' && <Recovery/>}
        </>
    )
}
