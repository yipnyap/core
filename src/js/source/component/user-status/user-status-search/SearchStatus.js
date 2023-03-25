import React, {useRef} from 'react';

import Avatar from '../../avatar/Avatar';

import IconSVG from '../../icon/IconSVG';

import BadgeVerified from '../../badge/BadgeVerified';

import {getSearchStatusTypeData} from '@legacy/component/utils/search';

import postUtils from '@legacy/component/utils/post';

function SearchStatus(props) {
    const [statusTitle, statusText, statusIcon] = getSearchStatusTypeData(props.type, props.data);

    const postCoverStyle = useRef(props.data.cover_url_thumb ? {background: `url(${props.data.cover_url_thumb}) center center / cover no-repeat`} : {});
    const postFormatIcon = postUtils.getPostFormatIcon(props.data.format);

    const displayVerifiedMemberBadge = yipnyap_constants.plugin_active['bp-verified-member'] && (props.type === 'user') && props.data.verified,
        displayVerifiedMemberBadgeInUsername = displayVerifiedMemberBadge && yipnyap_constants.settings.bp_verified_member_display_badge_in_profile_username,
        displayVerifiedMemberBadgeInFullname = displayVerifiedMemberBadge && yipnyap_constants.settings.bp_verified_member_display_badge_in_profile_fullname;

    return (
        <div className="user-status notification">
            {
                (props.type === 'user' || props.type === 'group') &&
                <Avatar size="small"
                        modifiers="user-status-avatar"
                        data={props.data}
                        noBorder
                        noLink
                />
            }
            {
                props.type === 'post' &&
                <React.Fragment>
                    {
                        props.data.cover_url &&
                        <div className="user-status-avatar picture small round" style={postCoverStyle.current}></div>
                    }
                    {
                        !props.data.cover_url &&
                        <div className="post-format-tag">
                            <IconSVG icon={postFormatIcon}
                                     modifiers="post-format-tag-icon"
                            />
                        </div>
                    }
                </React.Fragment>
            }

            <p className="user-status-title">
                <span className="bold">{statusTitle}</span>
                {
                    displayVerifiedMemberBadgeInFullname &&
                    <BadgeVerified/>
                }
            </p>
            <p className="user-status-text">{statusText}
                {
                    displayVerifiedMemberBadgeInUsername &&
                    <BadgeVerified/>
                }
            </p>

            <IconSVG icon={statusIcon}
                     modifiers='user-status-icon'
            />
        </div>
    );
}

export {SearchStatus as default};
