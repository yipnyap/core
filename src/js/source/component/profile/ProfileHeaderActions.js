import React, {useState, useEffect} from 'react';

import AddFriendButton from '../button/action-button/action-button-friend/AddFriendButton';
import AcceptFriendRequestButton from '../button/action-button/action-button-friend/AcceptFriendRequestButton';
import RejectFriendRequestButton from '../button/action-button/action-button-friend/RejectFriendRequestButton';
import WithdrawFriendRequestButton from '../button/action-button/action-button-friend/WithdrawFriendRequestButton';
import RemoveFriendButton from '../button/action-button/action-button-friend/RemoveFriendButton';

import FollowButton from '../button/action-button/action-button-follow/FollowButton';
import UnfollowButton from '../button/action-button/action-button-follow/UnfollowButton';

import ButtonLink from '../button/ButtonLink';

import * as userRouter from '@legacy/router/user/user-router';

import friendUtils from '@legacy/component/utils/friend';
import followUtils from '@legacy/component/utils/follow';

function ProfileHeaderActions(props) {
    const [loggedUser, setLoggedUser] = useState(false);
    const [rejecting, setRejecting] = useState(false);
    const [accepting, setAccepting] = useState(false);

    const startRejecting = () => {
        setRejecting(true);
    };

    const startAccepting = () => {
        setAccepting(true);
    };

    const getLoggedInMember = (callback = () => {
    }) => {
        userRouter.getLoggedInMember('user-friends')
            .done((response) => {
                

                setLoggedUser(response);
                setRejecting(false);
                setAccepting(false);

                callback();
            });
    };

    const reloadWindow = () => {
        window.location.reload();
    };

    useEffect(() => {
        getLoggedInMember();
    }, []);

    const friendable = friendUtils(loggedUser, props.userID);
    const followable = followUtils(loggedUser, props.userID);

    return (
        <div className="profile-header-info-actions">
            {
                loggedUser && (loggedUser.id !== props.userID) &&
                <React.Fragment>
                    {
                        !followable.isFollowing() &&
                        <FollowButton modifiers="profile-header-info-action secondary"
                                      text={yipnyap_translation.follow}
                                      loggedUser={loggedUser}
                                      userID={props.userID}
                                      onActionComplete={getLoggedInMember}
                        />
                    }
                    {
                        followable.isFollowing() &&
                        <UnfollowButton modifiers="profile-header-info-action tertiary"
                                        text={yipnyap_translation.unfollow}
                                        loggedUser={loggedUser}
                                        userID={props.userID}
                                        onActionComplete={getLoggedInMember}
                        />
                    }
                    {
                        !friendable.isFriend() &&
                        <React.Fragment>
                            {
                                !friendable.friendRequestSent() && !friendable.friendRequestReceived() &&
                                <AddFriendButton modifiers="profile-header-info-action secondary small"
                                                 icon="add-friend"
                                                 loggedUser={loggedUser}
                                                 userID={props.userID}
                                                 onActionComplete={getLoggedInMember}
                                />
                            }
                            {
                                friendable.friendRequestSent() &&
                                <WithdrawFriendRequestButton modifiers="profile-header-info-action tertiary"
                                                             text={yipnyap_translation.withdraw_friend}
                                                             loggedUser={loggedUser}
                                                             userID={props.userID}
                                                             onActionComplete={getLoggedInMember}
                                />
                            }
                            {
                                friendable.friendRequestReceived() &&
                                <RejectFriendRequestButton modifiers="profile-header-info-action tertiary"
                                                           text={yipnyap_translation.reject_friend}
                                                           loggedUser={loggedUser}
                                                           userID={props.userID}
                                                           onActionStart={startRejecting}
                                                           onActionComplete={getLoggedInMember}
                                                           locked={accepting}
                                />
                            }
                            {
                                friendable.friendRequestReceived() &&
                                <AcceptFriendRequestButton modifiers="profile-header-info-action secondary"
                                                           text={yipnyap_translation.accept_friend}
                                                           loggedUser={loggedUser}
                                                           userID={props.userID}
                                                           onActionStart={startAccepting}
                                                           onActionComplete={reloadWindow}
                                                           locked={rejecting}
                                />
                            }
                        </React.Fragment>
                    }
                    {
                        friendable.isFriend() &&
                        <React.Fragment>
                            <RemoveFriendButton modifiers="profile-header-info-action tertiary "
                                                icon="remove-friend"
                                                loggedUser={loggedUser}
                                                userID={props.userID}
                                                onActionComplete={reloadWindow}
                            />
                            {
                                yipnyap_constants.plugin_active.buddypress_messages &&
                                <ButtonLink modifiers="profile-header-info-action primary"
                                            text={yipnyap_translation.send_message}
                                            link={`${loggedUser.link}settings/messages?user_id=${props.userID}`}
                                />
                            }
                        </React.Fragment>
                    }
                </React.Fragment>
            }
        </div>
    );
}

export {ProfileHeaderActions as default};
