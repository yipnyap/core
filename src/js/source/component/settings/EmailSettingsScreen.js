import React, {useState, useEffect} from 'react';

import SectionHeader from '../section/SectionHeader';

import Loader from '../loader/Loader';
import LoaderSpinnerSmall from '../loader/LoaderSpinnerSmall';

import {deepMerge} from '../../utils/core';

import * as userRouter from '../../router/user/user-router';
import * as memberRouter from '../../router/member/member-router';

const emailSettings = [
    {
        name: yipnyap_translation.activity,
        options: [
            {
                id: 'notification_activity_new_mention',
                name: yipnyap_translation.mentions,
                description: yipnyap_translation.email_settings_mentions_description
            },
            {
                id: 'notification_activity_new_reply',
                name: yipnyap_translation.replies,
                description: yipnyap_translation.email_settings_replies_description
            }
        ]
    },
    {
        name: yipnyap_translation.messages,
        options: [
            {
                id: 'notification_messages_new_message',
                name: yipnyap_translation.new_message,
                description: yipnyap_translation.email_settings_newmessage_description
            }
        ]
    },
    {
        name: yipnyap_translation.friends,
        options: [
            {
                id: 'notification_friends_friendship_request',
                name: yipnyap_translation.new_friend_request,
                description: yipnyap_translation.email_settings_newfriendrequest_description
            },
            {
                id: 'notification_friends_friendship_accepted',
                name: yipnyap_translation.friend_request_accepted,
                description: yipnyap_translation.email_settings_friendrequestaccepted_description
            }
        ]
    },
    {
        name: yipnyap_translation.groups,
        options: [
            {
                id: 'notification_groups_invite',
                name: yipnyap_translation.group_invite,
                description: yipnyap_translation.email_settings_groupinvite_description
            },
            {
                id: 'notification_groups_group_updated',
                name: yipnyap_translation.group_update,
                description: yipnyap_translation.email_settings_groupupdate_description
            },
            {
                id: 'notification_groups_admin_promotion',
                name: yipnyap_translation.group_promotion,
                description: yipnyap_translation.email_settings_grouppromotion_description
            },
            {
                id: 'notification_groups_membership_request',
                name: yipnyap_translation.private_group_membership_request,
                description: yipnyap_translation.email_settings_privategroupmembershiprequest_description
            },
            {
                id: 'notification_membership_request_completed',
                name: yipnyap_translation.group_join_request_status,
                description: yipnyap_translation.email_settings_groupjoinrequeststatus_description
            }
        ]
    }
];

function EmailSettingsScreen(props) {
    const [loggedUser, setLoggedUser] = useState(false);

    const [settings, setSettings] = useState([]);
    const [savingSettings, setSavingSettings] = useState(false);

    const getLoggedInMember = () => {
        userRouter.getLoggedInMember('user-settings-notification')
            .done((response) => {
                console.log('EMAIL SETTINGS SCREEN - LOGGED IN USER: ', response);

                setLoggedUser(response);
                setSettings(deepMerge(response.email_settings));
            });
    };

    useEffect(() => {
        getLoggedInMember();
    }, []);

    const toggleSetting = (settingID) => {
        setSettings(previousSettings => {
            const newSettings = deepMerge(previousSettings);

            newSettings[settingID] = newSettings[settingID] === 'yes' ? 'no' : 'yes';

            return newSettings;
        });
    };

    const saveSettings = () => {
        // return if already saving
        if (savingSettings) {
            return;
        }

        setSavingSettings(true);

        const saveSettingsPromise = memberRouter.updateUserMetadata({
            user_id: loggedUser.id,
            metadata: settings
        });

        saveSettingsPromise
            .done((response) => {
                // refresh page
                window.location.reload();
            })
            .fail((error) => {
                setSavingSettings(false);
            });
    };

    return (
        <div className="account-hub-content">
            <SectionHeader pretitle={yipnyap_translation.my_profile} title={yipnyap_translation.email_settings}/>
            {
                !loggedUser &&
                <Loader/>
            }
            {
                loggedUser &&
                <React.Fragment>
                    <div className="grid-column">
                        {
                            emailSettings.map((section) => {
                                return (
                                    <div key={section.name} className="widget-box">
                                        <p className="widget-box-title">{section.name}</p>

                                        {/* WIDGET BOX CONTENT */}
                                        <div className="widget-box-content">
                                            {/* SWITCH OPTION LIST */}
                                            <div className="switch-option-list">
                                                {
                                                    section.options.map((option) => {
                                                        return (
                                                            <div key={option.id} className="switch-option">
                                                                <p className="switch-option-title">{option.name}</p>

                                                                <p className="switch-option-text">{option.description}</p>

                                                                <div
                                                                    className={`form-switch ${settings[option.id] !== 'no' ? 'active' : ''}`}
                                                                    onClick={() => {
                                                                        toggleSetting(option.id);
                                                                    }}
                                                                >
                                                                    <div className="form-switch-button"></div>
                                                                </div>
                                                            </div>
                                                        );
                                                    })
                                                }
                                            </div>
                                            {/* SWITCH OPTION LIST */}
                                        </div>
                                        {/* WIDGET BOX CONTENT */}
                                    </div>
                                );
                            })
                        }
                    </div>

                    {/* ACCOUNT HUB CONTENT OPTIONS */}
                    <div className="account-hub-content-options">
                        <div className="button primary" onClick={saveSettings}>
                            {
                                !savingSettings &&
                                yipnyap_translation.save_changes
                            }
                            {
                                savingSettings &&
                                <React.Fragment>
                                    {yipnyap_translation.saving}
                                    <LoaderSpinnerSmall/>
                                </React.Fragment>
                            }
                        </div>
                    </div>
                    {/* ACCOUNT HUB CONTENT OPTIONS */}
                </React.Fragment>
            }
        </div>
    );
}

export {EmailSettingsScreen as default};
