import React, {useState, useEffect} from 'react';

import SectionHeader from '../section/SectionHeader';

import UserGroupManagePreview from '../user-preview/UserGroupManagePreview';

import ActionBox from '../action/ActionBox';

import Notification from '../notification/Notification';

import Loader from '../loader/Loader';

import * as userRouter from '@legacy/router/user/user-router';

import groupUtils from '@legacy/component/utils/group';
import AlertLine from "../alert/AlertLine";

function ManageGroupsSettingsScreen(props) {
    const [loggedUser, setLoggedUser] = useState(false);

    const getLoggedInMember = () => {
        userRouter.getLoggedInMember('user-groups-preview')
            .done((response) => {
                

                setLoggedUser(response);
            });
    };

    useEffect(() => {
        getLoggedInMember();
    }, []);

    // only show groups the user is an admin or mod of
    const groups = loggedUser ? loggedUser.groups.filter(group => group.is_admin || group.is_mod) : [],
        userCanCreateGroups = !yipnyap_constants.settings.bp_restrict_group_creation || yipnyap_constants.settings.current_user_is_admin;

    return (
        <div className="account-hub-content">
            <SectionHeader pretitle={yipnyap_translation.groups} title={yipnyap_translation.manage_groups}/>
            {
                !loggedUser &&
                <Loader/>
            }
            {
                loggedUser &&
                <React.Fragment>
                    <AlertLine type={'info'}
                               title={'Important information regarding NSFW content'}
                               text={'If you are wanting a group to allow NSFW content, for now you must make the group private, as we are still working on a way to allow NSFW content in public groups.'}
                               margin={'b'}
                    />

                    {
                        (userCanCreateGroups || (groups.length > 0)) &&
                        <div className="grid grid-3-3-3 centered-on-mobile">
                            {
                                userCanCreateGroups &&
                                <ActionBox title={yipnyap_translation.create_new_group}
                                           text={yipnyap_translation.create_new_group_text}
                                           actionText={yipnyap_translation.start_creating}
                                           loggedUser={loggedUser}
                                />
                            }

                            {
                                (groups.length > 0) && groups.map((group) => {
                                    let groupPreviewDescriptionText = '';

                                    const groupable = groupUtils(loggedUser, group);

                                    if (groupable.isGroupCreator()) {
                                        groupPreviewDescriptionText = yipnyap_translation.group_creator;
                                    } else if (groupable.isGroupAdmin()) {
                                        groupPreviewDescriptionText = yipnyap_translation.group_admin;
                                    } else if (groupable.isGroupMod()) {
                                        groupPreviewDescriptionText = yipnyap_translation.group_mod;
                                    }

                                    return (
                                        <UserGroupManagePreview key={group.id}
                                                                data={group}
                                                                loggedUser={loggedUser}
                                                                descriptionText={groupPreviewDescriptionText}
                                        />
                                    );
                                })
                            }
                        </div>
                    }
                    {
                        !userCanCreateGroups && (groups.length === 0) &&
                        <Notification title={yipnyap_translation.no_groups_found}
                                      text={yipnyap_translation.cant_manage_groups_message}
                        />
                    }
                </React.Fragment>
            }
        </div>
    );
}

export {ManageGroupsSettingsScreen as default};
