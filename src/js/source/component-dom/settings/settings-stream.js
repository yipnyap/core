import React from 'react';
import ReactDOM from 'react-dom';

import StreamSettingsScreen from '../../component/legacy/settings/StreamSettingsScreen';

const streamSettingsElement = document.querySelector('#stream-settings-screen');

if (streamSettingsElement) {
  ReactDOM.render(
    <StreamSettingsScreen />,
    streamSettingsElement
  );
}
