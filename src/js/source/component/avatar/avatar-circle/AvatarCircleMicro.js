import React from 'react';

function AvatarCircleMicro(props) {
    const noBorderClasses = props.noBorder ? 'no-border' : '';
    const Element = props.noLink || !yipnyap_constants.plugin_active.buddypress ? 'div' : 'a';

    return (
        <Element className={`user-avatar-circle micro ${noBorderClasses} ${props.modifiers || ''}`}
                 {...(!props.noLink ? {href: props.data.link} : {})}
        >
            {/* USER AVATAR CIRCLE IMAGE */}
            <img className="user-avatar-circle-image" src={props.data.avatar_url}
                 alt={props.group ? 'group-avatar' : 'user-avatar'}/>
            {/* USER AVATAR CIRCLE IMAGE */}
        </Element>
    );
}

export {AvatarCircleMicro as default};
