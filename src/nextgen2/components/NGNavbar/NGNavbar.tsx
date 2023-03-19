import {NGButton} from '@nextgen2/components';
import {NGCommandPalette} from '@nextgen2/components/NGCommandPalette';
import {Fragment, useState} from 'react'
import {Disclosure, Menu, Transition} from '@headlessui/react'
import {MagnifyingGlassIcon} from '@heroicons/react/20/solid'
import {BellIcon, Bars3Icon, XMarkIcon} from '@heroicons/react/24/outline'
import {useNavigate} from 'react-router-dom';

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
                        className="relative z-40 bg-sidebar border-0 border-b border-default border-solid dark:bg-sidebar-dark">
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
                                         className="w-full cursor-pointer sm:max-w-xs hover:opacity-75 transition-opacity">
                                        <label htmlFor="search" className="sr-only">
                                            Search
                                        </label>
                                        <div className="relative">
                                            <div
                                                className="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                                <MagnifyingGlassIcon className="h-5 w-5 text-neutral-400"
                                                                     aria-hidden="true"/>
                                            </div>
                                            <span
                                                className="block w-full bg-box-solid border border-neutral-300 rounded-default py-2 pl-10 pr-3 text-sm text-neutral-500">
                                                Search
                                            </span>
                                            {/* Ctrl + K button */}
                                            <div
                                                className="absolute inset-y-0 right-0 flex items-center pr-2 text-neutral-400/25">
                                                <kbd
                                                    className="mx-1 py-1 px-2 flex items-center justify-center text-xs rounded border bg-box font-semibold sm:mx-2 border-neutral-400 text-neutral-500"
                                                >Ctrl</kbd>
                                                <span> + </span>
                                                <kbd
                                                    className="mx-1 py-1 px-2 flex items-center justify-center text-xs rounded border bg-box font-semibold sm:mx-2 border-neutral-400 text-neutral-500"
                                                >K</kbd>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="relative z-10 flex items-center lg:hidden">
                                    {/* Mobile menu button */}
                                    <Disclosure.Button
                                        className="rounded-md p-2 inline-flex items-center justify-center text-neutral-400 hover:bg-neutral-100 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
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
                                            <button
                                                type="button"
                                                className="flex-shrink-0 w-auto rounded-full p-1 text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >
                                                <span className="sr-only">View notifications</span>
                                                <BellIcon className="h-6 w-6" aria-hidden="true"/>
                                            </button>

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
                                                        className="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-box ring-1 ring-black ring-opacity-5 py-1 focus:outline-none">
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
                                                navigate('/id/login')
                                            )}>
                                                Login
                                            </NGButton>

                                            <NGButton onClick={() => (
                                                navigate('/id/create')
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
                                        className={classNames(item.current ? 'bg-neutral-100 text-neutral-900' : 'text-neutral-900 hover:bg-neutral-50 hover:text-neutral-900', 'block rounded-md py-2 px-3 text-base font-medium')}
                                        aria-current={item.current ? 'page' : undefined}
                                    >
                                        {item.name}
                                    </Disclosure.Button>
                                ))}
                            </div>
                            <div className="border-t border-neutral-200 pt-4 pb-3">
                                {props.user && (
                                    <div className="px-4 flex items-center">
                                        <div className="flex-shrink-0">
                                            <img className="h-10 w-10 rounded-full" src={props.user.avatar} alt=""/>
                                        </div>
                                        <div className="ml-3">
                                            <div
                                                className="text-base font-medium text-neutral-800">{props.user.display_name}</div>
                                            <div
                                                className="text-sm font-medium text-neutral-500">{props.user.username}</div>
                                        </div>
                                        <button
                                            type="button"
                                            className="ml-auto w-auto flex-shrink-0 bg-white rounded-full p-1 text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            <span className="sr-only">View notifications</span>
                                            <BellIcon className="h-6 w-6" aria-hidden="true"/>
                                        </button>
                                    </div>
                                )}
                                <div className="mt-3 px-2 space-y-1">
                                    {userNavigation.map((item) => (
                                        <Disclosure.Button
                                            key={item.name}
                                            as="a"
                                            href={item.href}
                                            className="block rounded-md py-2 px-3 text-base font-medium text-neutral-500 hover:bg-neutral-50 hover:text-neutral-900"
                                        >
                                            {item.name}
                                        </Disclosure.Button>
                                    ))}
                                </div>
                            </div>
                        </Disclosure.Panel>
                    </>
                )}
            </Disclosure>
        </>
    )
}
