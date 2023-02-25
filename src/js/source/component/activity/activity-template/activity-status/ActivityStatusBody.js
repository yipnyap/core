import React, {useRef} from 'react';

import PictureCollage from '../../../picture/PictureCollage';

import VideoPreview from '../../../video/VideoPreview';

import ActivityMediaPopup from '../../activity-popup/ActivityMediaPopup';

import {filterActivityContentForDisplay} from '@legacy/component/utils/activity/activity-filter';

function ActivityStatusBody(props) {
    const activityMediaPopupTriggerRef = useRef(null);

    const onPlay = () => {
        props.onPlay(props.data.id);
    };

    const bbPressActivity = (props.data.component === 'bbpress') || (props.data.type === 'bbp_topic_create') || (props.data.type === 'bbp_reply_create');

    const filteredActivityContent = filterActivityContentForDisplay(props.data.content);

    return (
        <div className="widget-box-status-content">
            {
                (props.data.content !== '') && !props.editForm &&
                <React.Fragment>
                    {
                        bbPressActivity &&
                        <div className="widget-box-status-html-content"
                             dangerouslySetInnerHTML={{__html: filteredActivityContent}}></div>
                    }

                    {
                        !bbPressActivity &&
                        <p className="widget-box-status-text"
                           dangerouslySetInnerHTML={{__html: filteredActivityContent}}></p>
                    }

                    {
                        props.data.meta.tags &&
                        <div className="widget-box-status-text flex flex-wrap text-primary">
                            {
                                props.data.meta.tags[0].split(',').map((tag, index) => {
                                    return (
                                        <span key={index} className="p-2 bg-box-over rounded-xl mr-1">{tag}</span>
                                    );
                                })
                            }
                        </div>
                    }
                </React.Fragment>
            }

            {
                props.data.uploaded_media && (props.data.uploaded_media.data.length > 1) &&
                <PictureCollage data={props.data.uploaded_media.data}
                                metadata={props.data.uploaded_media.metadata}
                                user={props.user}
                                reactions={props.reactions}
                                noPopup={props.simpleActivity}
                                onActivityUpdate={props.onActivityUpdate}
                />
            }

            {
                props.data.uploaded_media && (props.data.uploaded_media.data.length === 1) &&
                <React.Fragment>
                    {
                        ((props.data.type === 'activity_video_update') || (props.data.type === 'activity_video_upload')) &&
                        <VideoPreview src={props.data.uploaded_media.data[0].media.link}/>
                    }
                    {
                        ((props.data.type === 'activity_media_update') || (props.data.type === 'activity_media_upload')) &&
                        <React.Fragment>
                            <figure ref={activityMediaPopupTriggerRef} className="widget-box-picture">
                                <img src={props.data.uploaded_media.data[0].media.link}
                                     alt={props.data.uploaded_media.data[0].media.name}/>
                            </figure>

                            {
                                !props.simpleActivity &&
                                <ActivityMediaPopup data={props.data.uploaded_media.data[0]}
                                                    user={props.user}
                                                    reactions={props.reactions}
                                                    activityMediaPopupTriggerRef={activityMediaPopupTriggerRef}
                                                    onActivityUpdate={props.onActivityUpdate}
                                />
                            }
                        </React.Fragment>
                    }
                </React.Fragment>
            }
        </div>
    );
}

export {ActivityStatusBody as default};
