import React from 'react';

import ActivityMediaList from '../ActivityMediaList';
import ActivityVideoListOptions from './ActivityVideoListOptions';

import VideoItemList from '../../../video/VideoItemList';

function ActivityVideoList(props) {
    return (
        <ActivityMediaList activityListOptions={ActivityVideoListOptions}
                           gridModifiers="grid-3-3-3-3"
                           itemPreviewList={VideoItemList}
                           itemPreviewModifiers="video-box-cover-only"
                           activityGetType='activity_video'
                           activityCreateType='activity_video_upload'
                           sectionTitle={yipnyap_translation.videos}
                           noResultsTitle={yipnyap_translation.videos_no_results_title}
                           noResultsText={yipnyap_translation.videos_no_results_text}
                           {...props}
        />
    );
}

export {ActivityVideoList as default};
