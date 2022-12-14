import React from 'react';
import {IdentificationIcon} from '@heroicons/react/24/solid';

export function earlyAccess() {
  return {
    feature: {
      nextgen_profiles: {
        available: true,
        title: 'Nextgen Profiles',
        description: <>
          Nextgen Profiles are a new way to view and edit profiles. They are a work in progress and will be improved
          over time!
        </>,
        icon: IdentificationIcon,
        condition: 'everyone',
        conditionHumanReadable: 'Everyone'
      }
    }
  }
}
