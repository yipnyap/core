const notificationComponent = {
  friends: {
    icon: 'friend'
  },
  groups: {
    icon: 'group'
  },
  messages: {
    icon: 'messages'
  },
  forums: {
    icon: 'forums'
  },
  default: {
    icon: 'comment'
  }
};

const getNotificationComponentIcon = (component) => {
  return notificationComponent[component] ? notificationComponent[component].icon : notificationComponent.default.icon;
};

export { getNotificationComponentIcon };