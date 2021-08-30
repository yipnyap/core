import React from 'react';

import Avatar from '../../avatar/Avatar';

import Checkbox from '../../form/Checkbox';

import IconSVG from '../../icon/IconSVG';

import BadgeVerified from '../../badge/BadgeVerified';

import { getNotificationComponentIcon } from '../../utils/notification';

function NotificationStatus(props) {
  const statusIcon = getNotificationComponentIcon(props.data.component);

  const displayVerifiedMemberBadge = vikinger_constants.plugin_active['bp-verified-member'] && props.data.user && props.data.user.verified;

  return (
    <div className="user-status notification">
    {
      props.data.user &&
        <Avatar size="small"
                modifiers="user-status-avatar"
                data={props.data.user}
                noBorder
        />
    }
      
    {
      !props.data.user && props.data.group &&
        <Avatar size="small"
                modifiers="user-status-avatar"
                data={props.data.group}
                noBorder
        />
    }
        
      <p className="user-status-title">
      {
        props.data.user &&
          <React.Fragment>
            <a className="bold" href={props.data.user.link}>{props.data.user.name}</a>
            {
              displayVerifiedMemberBadge &&
                <BadgeVerified />
            }
          </React.Fragment>
      }
        <span dangerouslySetInnerHTML={{__html: ` ${props.data.description}`}}></span>
      </p>
      <p className="user-status-timestamp">{props.data.timestamp}</p>

      <IconSVG  icon={statusIcon}
                modifiers="user-status-icon"
      />

      {
        props.selectable &&
          <Checkbox active={props.selected}
                    modifiers="small"
                    toggleActive={props.toggleSelectableActive}
          />
      }
    </div>
  );
}

export { NotificationStatus as default };