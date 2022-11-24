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
          over time. They are currently available only to Verified users.
          <br /><br />
          You might not be able to see Nextgen Profiles yet, as they have conditions on when they are shown. You cannot
          force them to be shown.
        </>,
        icon: IdentificationIcon,
        condition: 'verified',
        conditionHumanReadable: 'Verified users only'
      }
    }
  }
}
