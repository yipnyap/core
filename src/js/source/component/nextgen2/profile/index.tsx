import React, {useEffect, useState} from 'react';

import {NGProfileHeader} from '../../../nextgen/components/NGProfileHeader';
import getMember from "../../../router/v2/members/get";

interface NGProfileType {
    id: number;
    username: string;
    avatar: string;
    banner?: string;
    bio?: string;
    followers?: number;
    following?: number;
    verified?: boolean;
    rank?: {
        id: number;
        name: string;
        current: number;
        total: number;
    }
}

export default function Profile({...props}) {
    const [user, setUser] = useState<NGProfileType | false>(false);
    const {userID} = props;

    useEffect(() => {
        const userPromise = userID ? getMember(userID) : null;
        userPromise?.then((user) => {
            console.log(user);
            setUser(user);
        })
    }, [userID])

    return (
        <div className="px-4 md:pl-24 pr-4 pt-4">
            {user &&
                <NGProfileHeader
                    user={user}
                    loggedIn={yipnyap_constants.currentUser}
                    self={yipnyap_constants.currentUser === user.username}
                    defaults={{
                        header: `${yipnyap_constants.yipnyap_url}/img/cover/default-cover.png`
                    }}
                />
            }
        </div>
    )
}
