import React, {useEffect} from "react";
import {useLocation} from "react-router-dom";
import {
    KeyIcon, LifebuoyIcon,
    UserPlusIcon,
} from "@heroicons/react/24/outline";
import {useHeading} from "../../../../providers/PageHeading.provider";
import {Void} from "../..";
import Login from "./login";
import Register from "./create";
import Recovery from "./recovery";

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
