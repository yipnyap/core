import React from 'react';
import {NGNavbar} from '@nextgen2/components';
import {useTheme} from '@nextgen2/providers/Theme.provider';
import {NGContentNavigator} from '../NGContentNavigator';
import {NGContentNavigatorItemType} from '../NGContentNavigator/NGContentNavigator';
import {NavLink} from 'react-router-dom';
// @ts-ignore
import { Flags } from 'react-feature-flags';
import Header from "@nextgen2/components/Layout/JoyUI/Header";
import Layout from "@nextgen2/components/Layout/JoyUI/Layout";

interface NGSideNavItemType {
    name: string;
    href: string;
    icon: ((props: React.SVGProps<SVGSVGElement>) => JSX.Element) | string;
}

export declare interface NGSideNavType {
    items: NGSideNavItemType[] | null;
    showContentNavigator?: boolean;
    slimContentNavigator?: boolean;
    contentNavigatorItems?: NGContentNavigatorItemType[];
    contentNavigatorHeading?: string | null;
    logoURL?: string;
    theme?: any;
    children?: React.ReactNode;
}

export default function NGSideNav({...props}: NGSideNavType) {
    const [theme] = useTheme();
    const logoURL = props.logoURL || yipnyap_constants.logo_url || 'https://yipnyap.me/vault/@server/uploads/2022/04/cropped-yipnyap-logo.png';
    const { items } = props;

    const themeAccent = theme.accent === 'neutral' ? 'neutralOld' : theme.accent;

    return (
        <div className="flex flex-col w-full">
            <Flags
                authorizedFlags={['JoyUINavigation']}
                renderOn={() =>
                    <>
                        <div className="flex flex-row h-full overflow-y-auto">
                            <div id="NGContentArea" className="flex-1 min-w-0 flex flex-col overflow-hidden">
                                <Layout.Root>
                                    <Header/>
                                    <NGContentNavigator globalItems={items}
                                                        slimContentNavigator={props.slimContentNavigator || false}
                                                        items={props.contentNavigatorItems || []}
                                                        heading={props.contentNavigatorHeading}/>

                                    {props.children}
                                </Layout.Root>
                            </div>
                        </div>
                    </>
                }
                renderOff={() => (
                    <div className="flex flex-row h-full overflow-y-auto">
                        {/* Static sidebar for desktop */}
                        {items && (
                            <div className="hidden lg:flex lg:flex-shrink-0">
                                <div className="flex flex-col w-20">
                                    <div
                                        className={`flex-1 flex flex-col min-h-0 overflow-y-auto bg-${themeAccent}-600 dark:bg-${themeAccent}-700`}>
                                        <div className="flex-1">
                                            <div
                                                className={`bg-${themeAccent}-700 py-4 flex items-center justify-center dark:bg-${themeAccent}-800`}>
                                                <img
                                                    className="h-8 w-auto rounded-lg"
                                                    src={logoURL}
                                                    alt="Yipnyap"
                                                />
                                            </div>
                                            <nav aria-label="Sidebar" className="py-6 flex flex-col items-center space-y-3">
                                                {items.map((item) => (
                                                    <NavLink
                                                        key={item.name}
                                                        to={item.href}
                                                        className={`flex cursor-pointer items-center p-4 rounded-lg text-${themeAccent}-200 hover:bg-${themeAccent}-700 hover:text-${themeAccent}-200`}
                                                    >
                                                        {typeof item.icon !== 'string' && (
                                                            <item.icon className="h-6 w-6" aria-hidden="true"/>
                                                        )}

                                                        {typeof item.icon === 'string' && (
                                                            <img
                                                                className="h-6 w-6 rounded-lg"
                                                                src={item.icon}
                                                                alt={`Icon for ${item.name}`}/>
                                                        )}
                                                        <span className="sr-only">{item.name}</span>
                                                    </NavLink>
                                                ))}
                                            </nav>
                                        </div>
                                        {yipnyap_constants.currentUser && (
                                            <div className="flex-shrink-0 flex pb-5">
                                                <NavLink to={`/settings/`}
                                                         className="cursor-pointer flex-shrink-0 w-full">
                                                    <img
                                                        className="block mx-auto h-10 w-10 rounded-full"
                                                        src={yipnyap_constants.currentUser?.avatar || '/img/default-avatar.png'}
                                                        alt=""
                                                    />
                                                    <div className="sr-only">
                                                        <p>{yipnyap_constants.currentUser?.username}</p>
                                                        <p>Account settings</p>
                                                    </div>
                                                </NavLink>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        )}

                        <div id="NGContentArea" className="flex-1 min-w-0 flex flex-col overflow-hidden">
                            <main className="flex-1 flex overflow-hidden">
                                <div className="flex-1 flex flex-col overflow-hidden">
                                    <div className="flex-1 flex overflow-hidden">
                                        {/* Content Navigator */}
                                        {props.showContentNavigator && (
                                            // @ts-ignore
                                            <NGContentNavigator globalItems={items}
                                                                slimContentNavigator={props.slimContentNavigator || false}
                                                                items={props.contentNavigatorItems || []}
                                                                heading={props.contentNavigatorHeading}/>
                                        )}
                                        {/* Main content */}
                                        {props.children}
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                )}
            />
        </div>
    );
}
