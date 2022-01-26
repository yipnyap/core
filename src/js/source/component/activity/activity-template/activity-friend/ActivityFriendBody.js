import React from 'react';

import Avatar from '../../../avatar/Avatar';

import BadgeVerified from '../../../badge/BadgeVerified';

import ButtonLink from '../../../button/ButtonLink';

import friendUtils from '../../../utils/friend';

function ActivityFriendBody(props) {
    let friendable;

    if (props.user) {
        friendable = friendUtils(props.user, props.data.friend.id);
    }

    const displayVerified = yipnyap_constants.plugin_active['bp-verified-member'] && yipnyap_constants.settings.bp_verified_member_display_badge_in_activity_stream,
        displayVerifiedMemberFriendBadge = displayVerified && props.data.friend.verified,
        displayVerifiedMemberFriendBadgeInUsername = displayVerifiedMemberFriendBadge && yipnyap_constants.settings.bp_verified_member_display_badge_in_profile_username,
        displayVerifiedMemberFriendBadgeInFullname = displayVerifiedMemberFriendBadge && yipnyap_constants.settings.bp_verified_member_display_badge_in_profile_fullname;

    return (
        <div className="widget-box-status-content">
            {/* USER PREVIEW WIDGET */}
            <div className="user-preview-widget">
                <a href={props.data.friend.link}>
                    <div className="user-preview-widget-cover"
                         style={{background: `url('${props.data.friend.cover_url}') center center / cover no-repeat`}}></div>
                </a>

                <div className="user-short-description small">
                    <Avatar modifiers="user-short-description-avatar"
                            data={props.data.friend}
                    />

                    <p className="user-short-description-title">
                        <a href={props.data.friend.link}>{props.data.friend.name}</a>
                        {
                            displayVerifiedMemberFriendBadgeInFullname &&
                            <BadgeVerified/>
                        }
                    </p>
                    <p className="user-short-description-text">
                        <a href={props.data.friend.link}>&#64;{props.data.friend.mention_name}</a>
                        {
                            displayVerifiedMemberFriendBadgeInUsername &&
                            <BadgeVerified/>
                        }
                    </p>
                </div>

                {/* USER PREVIEW WIDGET FOOTER */}
                <div className="user-preview-widget-footer">
                    {/* USER PREVIEW WIDGET FOOTER ACTION */}
                    <div className="user-preview-widget-footer-action"></div>
                    {/* USER PREVIEW WIDGET FOOTER ACTION */}

                    {/* USER PREVIEW WIDGET FOOTER ACTION */}
                    <div className="user-preview-widget-footer-action">
                        {
                            yipnyap_constants.plugin_active.buddypress_messages && props.user && (props.user.id !== props.data.friend.id) && friendable.isFriend() &&
                            <ButtonLink modifiers="primary"
                                        title={yipnyap_translation.send_message}
                                        icon="messages"
                                        link={`${props.user.messages_link}?user_id=${props.data.friend.id}`}
                            />
                        }
                    </div>
                    {/* USER PREVIEW WIDGET FOOTER ACTION */}
                </div>
                {/* USER PREVIEW WIDGET FOOTER */}
            </div>
            {/* USER PREVIEW WIDGET */}
        </div>
    );
}

export {ActivityFriendBody as default};
