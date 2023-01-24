import React, {useEffect} from "react";
import {useLocation} from "react-router-dom";
import {
    Cog6ToothIcon,
    PaperAirplaneIcon,
} from "@heroicons/react/24/outline";
import {useHeading} from "../../../../providers/PageHeading.provider";
import {Void} from "../..";
import Login from "./login";

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
                        icon: Cog6ToothIcon,
                        current: location.pathname === '/id/login',
                    },
                    {
                        name: 'Register',
                        description: '',
                        href: '/id/create',
                        icon: PaperAirplaneIcon,
                        current: location.pathname === '/id/create',
                    },
                ]
            }
        })
    }, [location.pathname])

    return (
        <>
            {!heading?.navigator?.subNavigation?.find((item) => item.current) && <Void/>}
            {location.pathname === '/id/login' && <Login/>}
        </>
    )
}
