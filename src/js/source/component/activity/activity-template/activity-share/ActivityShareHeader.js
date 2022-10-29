import React from 'react';

import Avatar from '../../../avatar/Avatar';

import BadgeVerified from '../../../badge/BadgeVerified';

import EditedByStatus from '../../../user-status/user-status-edited-by/EditedByStatus';

function ActivityShareHeader(props) {
    const displayVerifiedMemberBadge = yipnyap_constants.plugin_active['bp-verified-member'] && yipnyap_constants.settings.bp_verified_member_display_badge_in_activity_stream && props.data.author.verified;

    return (
        <div className="widget-box-status-header">
            <div className="user-status">
                <div className="user-status-avatar">
                    <Avatar size="small"
                            data={props.data.author}
                            noBorder
                    />
                </div>

                <div className="user-status-title medium">
                    <a href={props.data.author.link}>{props.data.author.name}</a>
                    {
                        displayVerifiedMemberBadge &&
                        <BadgeVerified/>
                    }
                    <span dangerouslySetInnerHTML={{__html: ` ${props.data.action}`}}></span>
                    {
                        (props.data.component === 'groups') &&
                        <React.Fragment>
                            <Avatar size="micro"
                                    data={props.data.group}
                                    noBorder
                                    group
                            />
                            <a href={props.data.group.link}>{props.data.group.name}</a>
                        </React.Fragment>
                    }
                </div>

                <a className="user-status-text small" href={props.data.permalink}>
                    {props.data.author.flair ? props.data.author.flair + ' •' : ''} {props.data.timestamp}
                    {
                        props.data.last_edited &&
                        <EditedByStatus user={props.data.last_edited.user}/>
                    }
                </a>
            </div>
        </div>
    );
}

export {ActivityShareHeader as default};
