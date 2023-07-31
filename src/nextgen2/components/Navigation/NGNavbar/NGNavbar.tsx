import {NGButton} from '@nextgen2/components';
import {NGCommandPalette} from '@nextgen2/components/Overlays/NGCommandPalette';
import {Fragment, useState} from 'react'
import {Disclosure, Menu, Transition} from '@headlessui/react'
import {MagnifyingGlassIcon} from '@heroicons/react/20/solid'
import {BellIcon, Bars3Icon, XMarkIcon} from '@heroicons/react/24/outline'
import {Link, useNavigate} from 'react-router-dom';

function classNames(...classes: string[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGNavbar({...props}: { user: any; pages: any[]; }) {
    const navigate = useNavigate();
    const [paletteOpen, setPaletteOpen] = useState(false);

    const userNavigation = [{
        name: 'Your Profile',
        href: `/${props.user?.username || 'id/create'}/`,
    }, {
        name: 'Settings',
        href: '/settings/',
    }, {
        name: 'Sign out',
        href: yipnyap_constants.logout_url,
    }]

    return (
        <>
            <NGCommandPalette states={[paletteOpen, setPaletteOpen]}
                              friends={props.user?.friends || []}
                              groups={props.user?.groups || []}
                              pages={props.pages || []}
            />

            <Disclosure as="header"
                        className="sticky top-0 z-40 bg-sidebar-default/75 backdrop-blur-lg border-0 border-b border-default border-solid dark:bg-sidebar-dark/75">
                {({open}) => (
                    <>
                        <div className="max-w-7xl mx-auto px-2 sm:px-4 lg:divide-y lg:divide-neutral-200 lg:px-8">
                            <div className="relative h-16 flex justify-between">
                                <div className="relative"></div>
                                <div
                                    className="relative z-0 flex-1 px-2 flex items-center justify-center sm:absolute sm:inset-0">
                                    <div onClick={(
                                        () => setPaletteOpen(true)
                                    )}
                                         className="relative flex rounded-md bg-black/5 dark:bg-white/5 w-full cursor-pointer sm:max-w-xs hover:opacity-75 transition-opacity">
                                        <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <MagnifyingGlassIcon className="h-5 w-5 text-default-alt" aria-hidden="true" />
                                        </div>
                                        <input
                                            disabled
                                            name="text"
                                            className="no-legacy block flex-1 bg-transparent cursor-pointer border-0 py-1.5 pl-10 placeholder:text-neutral-400 sm:text-sm sm:leading-6"
                                            placeholder="Search"
                                        />
                                        {/* Ctrl + K button */}
                                        <div className="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                            <kbd className="inline-flex items-center rounded border border-solid border-white/10 px-1 font-sans text-xs text-default-alt">
                                                ⌘K
                                            </kbd>
                                        </div>
                                    </div>
                                </div>
                                <div className="relative z-10 flex items-center lg:hidden">
                                    {/* Mobile menu button */}
                                    <Disclosure.Button
                                        className="rounded-md p-2 inline-flex items-center justify-center text-neutral-400 hover:bg-box-alt focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                        <span className="sr-only">Open menu</span>
                                        {open ? (
                                            <XMarkIcon className="block h-6 w-6" aria-hidden="true"/>
                                        ) : (
                                             <Bars3Icon className="block h-6 w-6" aria-hidden="true"/>
                                         )}
                                    </Disclosure.Button>
                                </div>
                                <div className="hidden lg:relative lg:z-10 lg:ml-4 lg:flex lg:items-center">
                                    {props.user && (
                                        <>
                                            <Link to="/notifications/">
                                                <button
                                                    type="button"
                                                    className="flex-shrink-0 w-auto rounded-full p-1 text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                >
                                                    <span className="sr-only">View notifications</span>
                                                    <BellIcon className="h-6 w-6" aria-hidden="true"/>
                                                </button>
                                            </Link>

                                            {/* Profile dropdown */}
                                            <Menu as="div" className="flex-shrink-0 relative ml-4">
                                                <div>
                                                    <Menu.Button
                                                        className="bg-white rounded-full flex focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <span className="sr-only">Open user menu</span>
                                                        <img className="h-8 w-8 rounded-full" src={props.user.avatar}
                                                             alt=""/>
                                                    </Menu.Button>
                                                </div>
                                                <Transition
                                                    as={Fragment}
                                                    enter="transition ease-out duration-100"
                                                    enterFrom="transform opacity-0 scale-95"
                                                    enterTo="transform opacity-100 scale-100"
                                                    leave="transition ease-in duration-75"
                                                    leaveFrom="transform opacity-100 scale-100"
                                                    leaveTo="transform opacity-0 scale-95"
                                                >
                                                    <Menu.Items
                                                        className="origin-top-right absolute right-0 mt-2 w-48 rounded-default shadow-lg bg-box-solid ring-1 ring-black ring-opacity-5 py-1 focus:outline-none">
                                                        {userNavigation.map((item) => (
                                                            <Menu.Item key={item.name}>
                                                                {({active}) => (
                                                                    <a
                                                                        href={item.href}
                                                                        className={classNames(active ? 'bg-box-alt' : '', 'block py-2 px-4 text-sm text-default')}
                                                                    >
                                                                        {item.name}
                                                                    </a>
                                                                )}
                                                            </Menu.Item>
                                                        ))}
                                                    </Menu.Items>
                                                </Transition>
                                            </Menu>
                                        </>
                                    )}

                                    {!props.user && (
                                        <div className="flex items-center space-x-4">
                                            <NGButton onClick={() => (
                                                navigate('/id/login/')
                                            )}>
                                                Login
                                            </NGButton>

                                            <NGButton onClick={() => (
                                                navigate('/id/create/')
                                            )}>
                                                Register
                                            </NGButton>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        <Disclosure.Panel as="nav" className="lg:hidden" aria-label="Global">
                            <div className="pt-2 pb-3 px-2 space-y-1">
                                {props.pages.map((item) => (
                                    <Disclosure.Button
                                        key={item.name}
                                        as="a"
                                        href={item.href}
                                        className={classNames(item.current ? 'text-default bg-default-alt' : `text-default hover:bg-box-alt`, 'block rounded-md py-2 px-3 text-base font-medium')}
                                        aria-current={item.current ? 'page' : undefined}
                                    >
                                        {item.name}
                                    </Disclosure.Button>
                                ))}
                            </div>
                            <div className="border-t border-neutral-200 pt-4 pb-3">
                                {props.user && (
                                    <>
                                        <div className="px-4 flex items-center">
                                            <div className="flex-shrink-0">
                                                <img className="h-10 w-10 rounded-full" src={props.user.avatar} alt=""/>
                                            </div>
                                            <div className="ml-3">
                                                <div
                                                    className="text-base font-medium text-default">{props.user.display_name}</div>
                                                <div
                                                    className="text-sm font-medium text-neutral-500">{props.user.username}</div>
                                            </div>
                                            <button
                                                type="button"
                                                className="ml-auto w-auto flex-shrink-0 rounded-full p-1 text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >
                                                <span className="sr-only">View notifications</span>
                                                <Link to="/notifications/">
                                                    <BellIcon className="h-6 w-6" aria-hidden="true"/>
                                                </Link>
                                            </button>
                                        </div>

                                        <div className="mt-3 px-2 space-y-1">
                                            {userNavigation.map((item) => (
                                                <Disclosure.Button
                                                    key={item.name}
                                                    as="a"
                                                    href={item.href}
                                                    className="block rounded-md py-2 px-3 text-base font-medium text-default-alt hover:bg-box-alt"
                                                >
                                                    {item.name}
                                                </Disclosure.Button>
                                            ))}
                                        </div>
                                    </>
                                )}
                            </div>
                        </Disclosure.Panel>
                    </>
                )}
            </Disclosure>
        </>
    )
}
