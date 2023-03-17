import {EyeIcon, ShieldCheckIcon, UserIcon} from '@heroicons/react/20/solid';
import React, {useEffect, useState} from 'react';
import {Link} from 'react-router-dom';

export default function PageModerateRoles({...props}: { group: any }) {
    const [group, setGroup] = useState<any>(props.group);

    props.group.roles = [{
        id: 1,
        name: 'Leader',
        description: 'Leaders are the owners of the group. They can do everything.',
        icon: EyeIcon,
    }, {
        id: 2,
        name: 'Moderator',
        description: 'Moderators can ban, kick, and view statistics of the group.',
        icon: ShieldCheckIcon,
    }, {
        id: 3,
        name: 'Member',
        description: 'Default role for all members.',
        icon: UserIcon,
    }];

    useEffect(() => {
        setGroup(props.group);
    }, [props.group]);

    return (
        <>
            {/* Roles */}
            <div className="flex flex-col">
                <div className="flex justify-between items-center">
                    <h3 className="text-lg leading-6 font-medium text-neutral-900 dark:text-neutral-100">
                        Roles
                    </h3>
                    {/*<Link to={`/groups/${group.id}/moderate/roles/create`}*/}
                    {/*      className="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-primary-700 focus:shadow-outline-primary active:bg-primary-700 transition ease-in-out duration-150">*/}
                    {/*    Create Role*/}
                    {/*</Link>*/}
                </div>
                <div className="mt-4">
                    <div className="flex flex-col">
                        <div className="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div className="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div
                                    className="bg-box shadow overflow-hidden border-b border-gray-200 sm:rounded-default">
                                    <table className="min-w-full divide-y divide-gray-200">
                                        <thead className="bg-box-alt">
                                        <tr>
                                            <th scope="col"
                                                className="text-default-alt px-6 py-3 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col"
                                                className="text-default-alt px-6 py-3 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th scope="col" className="px-6 py-3"></th>
                                        </tr>
                                        </thead>
                                        <tbody className="divide-y divide-gray-200">
                                        {/* <!-- Odd row --> */}
                                        {group.roles?.map((role: any) => (
                                            <tr key={role.id} className="hover:bg-box-alt">
                                                <td className="px-6 py-4 whitespace-no-wrap">
                                                    <div className="flex items-center">
                                                        <div className="flex-shrink-0 h-10 w-10">
                                                            <role.icon className="h-10 w-10 text-gray-400"
                                                                       aria-hidden="true"/>
                                                        </div>
                                                        <div className="ml-4">
                                                            <div
                                                                className="text-sm leading-5 font-medium text-default">
                                                                {role.name}
                                                            </div>
                                                            <div className="text-sm leading-5 text-default-alt">
                                                                {role.description}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-no-wrap">
                                                    <div
                                                        className="text-sm leading-5 text-default-alt">{role.description}</div>
                                                </td>
                                                {/*<td className="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">*/}
                                                {/*    <Link to={`/groups/${group.id}/moderate/roles/${role.id}`}*/}
                                                {/*          className="text-blue-600 hover:text-blue-900">Edit</Link>*/}
                                                {/*</td>*/}
                                            </tr>
                                        ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}