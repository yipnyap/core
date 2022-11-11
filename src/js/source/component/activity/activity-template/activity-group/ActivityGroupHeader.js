import React from 'react';

import Avatar from '../../../avatar/Avatar';

import BadgeVerified from '../../../badge/BadgeVerified';

function ActivityGroupHeader(props) {
    const displayVerified = yipnyap_constants.plugin_active['bp-verified-member'] && yipnyap_constants.settings.bp_verified_member_display_badge_in_activity_stream,
        displayVerifiedMemberBadge = displayVerified && props.data.author.verified;

    return (
        <div className="widget-box-status-header">
            <div className="user-status">
                <div className="user-status-avatar">
                    <Avatar size="small"
                            data={props.data.author}
                            noBorder
                    />
                </div>

                <p className="user-status-title medium">
                    <a href={props.data.author.link}>{props.data.author.name}</a>
                    {
                        displayVerifiedMemberBadge &&
                        <BadgeVerified/>
                    }
                    <span className="ml-2" dangerouslySetInnerHTML={{__html: ` ${props.data.action}`}}></span>
                </p>

                <p className="user-status-text small">{props.data.timestamp}</p>
            </div>
        </div>
    );
}

export {ActivityGroupHeader as default};
