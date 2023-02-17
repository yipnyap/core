import React from 'react';

import {getAvatarTemplate} from '@legacy/component/utils/avatar';

const avatarType = yipnyap_constants.settings.avatar_type;

function Avatar(props) {
    const avatarSize = props.size ? props.size : 'regular';
    const AvatarElement = getAvatarTemplate(avatarType, avatarSize);

    return (
        <AvatarElement {...props} />
    );
}

export {Avatar as default};
