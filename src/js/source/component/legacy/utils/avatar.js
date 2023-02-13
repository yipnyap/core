import AvatarCircle from '../avatar/avatar-circle/AvatarCircle';
import AvatarCircleMedium from '../avatar/avatar-circle/AvatarCircleMedium';
import AvatarCircleSmall from '../avatar/avatar-circle/AvatarCircleSmall';
import AvatarCircleSmaller from '../avatar/avatar-circle/AvatarCircleSmaller';
import AvatarCircleTiny from '../avatar/avatar-circle/AvatarCircleTiny';
import AvatarCircleMicro from '../avatar/avatar-circle/AvatarCircleMicro';

const avatarTemplate = {
  circle: {
    regular: AvatarCircle,
    medium: AvatarCircleMedium,
    small: AvatarCircleSmall,
    smaller: AvatarCircleSmaller,
    tiny: AvatarCircleTiny,
    micro: AvatarCircleMicro
  },
};

const getAvatarTemplate = (type, size) => {
  return avatarTemplate[type][size];
};

import AvatarCircleOverlaySmaller from '../avatar/avatar-circle/avatar-circle-overlay/AvatarCircleOverlaySmaller';

const avatarOverlayTemplate = {
  circle: {
    smaller: AvatarCircleOverlaySmaller
  },
};

const getAvatarOverlayTemplate = (type, size) => {
  return avatarOverlayTemplate[type][size];
};

export { getAvatarTemplate, getAvatarOverlayTemplate };
