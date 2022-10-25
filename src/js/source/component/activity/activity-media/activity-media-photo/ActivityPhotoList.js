import React from 'react';

import ActivityMediaList from '../ActivityMediaList';
import ActivityPhotoListOptions from './ActivityPhotoListOptions';

import PhotoPreviewList from '../../../picture/PhotoPreviewList';

function ActivityPhotoList(props) {
    return (
        <ActivityMediaList activityListOptions={ActivityPhotoListOptions}
                           gridModifiers="grid-2-2-2-2-2-2"
                           itemPreviewList={PhotoPreviewList}
                           itemPreviewModifiers="small"
                           activityGetType="activity_media"
                           activityCreateType="activity_media_upload"
                           sectionTitle={yipnyap_translation.photos}
                           noResultsTitle={yipnyap_translation.photos_no_results_title}
                           noResultsText={yipnyap_translation.photos_no_results_text}
                           {...props}
        />
    );
}

export {ActivityPhotoList as default};
