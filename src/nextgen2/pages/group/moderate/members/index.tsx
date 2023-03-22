import {Dialog, Transition} from '@headlessui/react';
import {ExclamationTriangleIcon} from '@heroicons/react/20/solid';
import {NGButton, NGSelectMenu, NGTable} from '@nextgen2/components';
import {NGProfileHeader} from '@nextgen2/components/NGProfileHeader';
import {Group} from '@nextgen2/pages/group/moderate';
import {useNotification} from '@nextgen2/providers/Notification.provider';
import React, {Fragment, useEffect, useRef, useState} from 'react';
import {Link, useLocation} from 'react-router-dom';

function ModDialog({...props}: {
    state: [boolean, React.Dispatch<React.SetStateAction<boolean>>],
    title: string,
    action: string,
    actionColor: string,
    actionOnClick: () => void,
    children: React.ReactNode
}) {
    const cancelButtonRef = useRef(null)
    const [open, setOpen] = props.state;

    return (
        <Transition.Root show={open} as={Fragment}>
            <Dialog as="div" className="fixed z-50 inset-0 overflow-y-auto" initialFocus={cancelButtonRef}
                    onClose={setOpen}>
                <div className="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <Transition.Child
                        as={Fragment}
                        enter="ease-out duration-300"
                        enterFrom="opacity-0"
                        enterTo="opacity-100"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                    >
                        <Dialog.Overlay
                            className="fixed inset-0 bg-neutral-500/25 bg-opacity-75 backdrop-blur transition-opacity"/>
                    </Transition.Child>

                    {/* This element is to trick the browser into centering the modal contents. */}
                    <span className="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">
                        &#8203;
                    </span>
                    <Transition.Child
                        as={Fragment}
                        enter="ease-out duration-300"
                        enterFrom="opacity-0 translate-y-4 rotate-1"
                        enterTo="opacity-100 translate-y-0 rotate-0"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100 translate-y-0 rotate-0 sm:scale-100"
                        leaveTo="opacity-0 translate-y-4 -rotate-1 sm:translate-y-0 sm:scale-95"
                    >
                        <div
                            className="relative inline-block align-bottom bg-box-alt rounded-default px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all border border-default border-solid sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div className="sm:flex sm:items-start">
                                <div
                                    className="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <ExclamationTriangleIcon className="h-6 w-6 text-red-600" aria-hidden="true"/>
                                </div>
                                <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <Dialog.Title as="h3" className="text-lg leading-6 font-medium text-default">
                                        {props.title}
                                    </Dialog.Title>
                                    <div className="mt-2">
                                        {typeof props.children === 'string' ? (
                                            <p className="text-sm text-default-alt">
                                                {props.children}
                                            </p>
                                        ) : props.children}
                                    </div>
                                </div>
                            </div>
                            <div className="mt-5 space-y-4 sm:space-x-4 sm:space-y-0 sm:mt-4 sm:ml-10 sm:pl-4 sm:flex">
                                <NGButton
                                    variant="danger"
                                    onClick={() => props.actionOnClick()}
                                >
                                    {props.action}
                                </NGButton>
                                <NGButton
                                    variant="lighter"
                                    onClick={() => setOpen(false)}
                                    ref={cancelButtonRef}
                                >
                                    Cancel
                                </NGButton>
                            </div>
                        </div>
                    </Transition.Child>
                </div>
            </Dialog>
        </Transition.Root>
    )
}

export default function PageModerateMembers({...props}: {
    group: Group; communicatingState: [boolean, React.Dispatch<React.SetStateAction<boolean>>]
}) {
    const location = useLocation();
    const [, addNotification] = useNotification();
    const [communicating, setCommunicating] = props.communicatingState;
    const [group, setGroup] = useState<Group>(props.group);
    const [memberID, setMemberID] = useState<string | null>(location.pathname.split('/')[5] || null);
    const [member, setMember] = useState<any>();

    const [open, setOpen] = useState(false);
    const [dialogTitle, setDialogTitle] = useState('');
    const [dialogDescription, setDialogDescription] = useState<string | JSX.Element>('');
    const [dialogAction, setDialogAction] = useState('');
    const [dialogActionColor, setDialogActionColor] = useState('');
    const [dialogActionOnClick, setDialogActionOnClick] = useState(() => () => {
    });

    const [selectedRole, setSelectedRole] = useState<{ name: string; }>({
        name: 'Unknown',
    });

    useEffect(() => {
        setGroup(props.group);
    }, [props.group]);

    useEffect(() => {
        const ID = location.pathname.split('/')[5];
        if (ID && ID !== '') {
            const memberFind = group.meta?.members?.data?.find((member: any) => member.id === parseInt(ID));
            setMemberID(ID);

            if (group.meta?.members?.count > 0 && memberFind) {
                setMember(memberFind);
                setSelectedRole({
                    name: memberFind.pivot.current,
                })
            } else {
                setMemberID(null);
                setMember(null);
            }
        } else {
            setMemberID(null);
            setMember(null);
        }
    }, [location.pathname, group]);

    // When the selected role changes, update the member's role via API
    useEffect(() => {
        if (group.meta?.members?.count > 0 && memberID && member && selectedRole.name !== member.pivot.current && selectedRole.name !== 'Unknown') {
            const previousRole = member.pivot.current;
            setCommunicating(true);
            fetch(`/api/v2/groups/${group.id}/members/${memberID}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
                },
                body: JSON.stringify({
                    role: selectedRole.name,
                }),
            }).then(async (response) => {
                const data = await response.json();
                setCommunicating(false);
                if (response.ok) {
                    addNotification({
                        type: 'success',
                        title: 'Role updated successfully.',
                    });

                    // Update the member's role in the group's member list
                    const memberIndex = group.meta.members.data.findIndex((member: any) => member.id === parseInt(memberID));
                    group.meta.members.data[memberIndex].pivot.current = selectedRole.name;
                    setGroup(group);
                } else {
                    addNotification({
                        type: 'error',
                        title: data.message || 'An unknown error occurred while updating the role.',
                    });
                    setSelectedRole({
                        name: previousRole,
                    });
                }
            });
        }
    }, [selectedRole]);

    function banDialog() {
        setDialogTitle('Ban Member');
        setDialogDescription(<>
            <p className="text-sm text-default-alt">
                Are you sure you want to ban this member? They will not be able to rejoin the group, and all of their
                content will be deleted.
            </p>
            <p className="mt-2 text-sm text-default-alt">
                If this member is being a lunatic, please <a
                href="https://work.yipnyap.me/maniphest/task/edit/form/default/" target="_blank">report them</a> as
                well.
            </p>
        </>);
        setDialogAction('Ban');
        setDialogActionColor('danger');
        setDialogActionOnClick(() => () => {
            setCommunicating(true);
            fetch(`/api/v2/groups/${group.id}/members/${memberID}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
                },
                body: JSON.stringify({
                    ban: true,
                }),
            }).then(async (response) => {
                const data = await response.json();
                setCommunicating(false);
                if (response.ok) {
                    // dirty filter the member out of the group. hacky, but works.
                    if (typeof memberID === 'string') {
                        setGroup({
                            ...group,
                            meta: {
                                ...group.meta,
                                members: {
                                    ...group.meta.members,
                                    data: group.meta.members.data.filter((member: any) => member.id !== parseInt(memberID)),
                                },
                            },
                        });
                    }

                    addNotification({
                        type: 'success',
                        title: 'Member Banned',
                    });
                } else {
                    addNotification({
                        type: 'error',
                        title: 'Error',
                        message: data.message || response.statusText,
                    });
                }
            });

            setOpen(false);
        });

        setOpen(true);
    }

    function kickDialog() {
        setDialogTitle('Kick Member');
        setDialogDescription('Are you sure you want to kick this member? They can rejoin at any time, and their content will remain. If you want to prevent them from rejoining, and delete their content within the group, you should ban them instead.');
        setDialogAction('Kick');
        setDialogActionColor('danger');
        setDialogActionOnClick(() => () => {
            setCommunicating(true);
            fetch(`/api/v2/groups/${group.id}/members/${memberID}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
                },
            }).then(async (response) => {
                const data = await response.json();
                setCommunicating(false);
                if (response.ok) {
                    // dirty filter the member out of the group. hacky, but works.
                    if (typeof memberID === 'string') {
                        setGroup({
                            ...group,
                            meta: {
                                ...group.meta,
                                members: {
                                    ...group.meta.members,
                                    data: group.meta.members.data.filter((member: any) => member.id !== parseInt(memberID)),
                                },
                            },
                        });
                    }

                    addNotification({
                        type: 'success',
                        title: 'Member Kicked',
                    });
                } else {
                    addNotification({
                        type: 'error',
                        title: 'Error',
                        message: data.message || response.statusText,
                    });
                }
            });

            setOpen(false);
        });

        setOpen(true);
    }

    function render() {
        switch (memberID) {
            case null: {
                return (
                    <div className="flex flex-col w-full">
                        <div className="flex justify-between items-center">
                            <h3 className="text-lg leading-6 font-medium text-neutral-900 dark:text-neutral-100">
                                Members
                            </h3>
                        </div>
                        <div className="mt-4">
                            <NGTable headers={['Name', 'Role', 'Joined', ...(
                                group.meta.pivot.current !== 'Member' ? ['Blank'] : []
                            )]}
                                     data={[...group.meta?.members?.data?.map((member: any) => {
                                         return {
                                             user: member,
                                             role: member.pivot.current !== 'Member',
                                             date: member.date_joined * 1000,
                                             edit: () => {
                                                 if (group.meta.pivot.current !== 'Member') {
                                                     return (
                                                         <Link
                                                             className="text-blue-600 hover:text-blue-900"
                                                             to={`members/${member.id}`}>
                                                             Edit
                                                         </Link>
                                                     )
                                                 } else {
                                                     return (
                                                         <></>
                                                     )
                                                 }
                                             },
                                         }
                                     })]}
                            />
                        </div>
                    </div>
                )
            }

            default: {
                return (
                    <>
                        {!member && (
                            <span
                                className="text-alt-2"><code>CientRouter::HUH</code> Probably loading, or deadlocked.</span>
                        )}

                        {member && (
                            <div className="flex flex-col space-y-8 w-full">
                                <NGProfileHeader user={member}/>
                                {/* Kick, ban, promote/demote */}
                                <div className="flex flex-col gap-8 md:flex-row">
                                    <div className="space-y-2 md:flex-grow">
                                        <h3 className="text-lg leading-6 font-medium text-default">
                                            Manage presence
                                        </h3>
                                        <div className="flex flex-row gap-4 w-min">
                                            <NGButton
                                                variant="danger"
                                                onClick={() => kickDialog()}
                                            >
                                                Kick
                                            </NGButton>
                                            <NGButton
                                                variant="danger"
                                                onClick={() => banDialog()}
                                            >
                                                Ban
                                            </NGButton>
                                        </div>
                                    </div>
                                    <div className="space-y-2 md:flex-grow">
                                        <h3 className="text-lg leading-6 font-medium text-default">
                                            Manage role
                                        </h3>
                                        <NGSelectMenu title="Selected Role"
                                                      selected={selectedRole}
                                                      onChange={(value: any) => {
                                                          setSelectedRole(value);
                                                      }}
                                                      options={[{
                                                          name: 'Member',
                                                      }, {
                                                          name: 'Moderator',
                                                      }, /*{
                                                          name: 'Administrator',
                                                      },*/ {
                                                          name: 'Leader',
                                                          disabled: true,
                                                      }]}/>
                                    </div>
                                </div>
                            </div>
                        )}

                        <ModDialog
                            state={[open, setOpen]}
                            title={dialogTitle}
                            action={dialogAction}
                            actionColor={dialogActionColor}
                            actionOnClick={dialogActionOnClick}>
                            {dialogDescription}
                        </ModDialog>
                    </>
                )
            }
        }
    }

    return (
        <>
            {render()}
        </>
    )
}