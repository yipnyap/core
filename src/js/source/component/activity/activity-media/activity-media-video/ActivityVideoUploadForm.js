import React, {useState} from 'react';

import ExpandableTextarea from '../../../form/ExpandableTextarea';

import VideoPreview from '../../../video/VideoPreview';
import UploadVideoButton from '../../../video/UploadVideoButton';

function ActivityVideoUploadForm(props) {
    const [formData, setFormData] = useState({
        text: '',
        submitting: false,
        uploadable_media: [],
        uploadable_media_type: 'video',
        errors: []
    });

    const discardContent = () => {
        setFormData(previousFormData => {
            return {
                ...previousFormData,
                text: '',
                uploadable_media: [],
                errors: []
            };
        });

        if (props.popup) {
            props.popup.hide();
        }
    };

    const submitContent = () => {
        // if didn't select any media, or already submitting form, return
        if ((formData.uploadable_media.length === 0) || formData.submitting) {
            setFormData(previousFormData => {
                return {
                    ...previousFormData,
                    errors: [
                        {
                            text: yipnyap_translation.upload_form_video_empty_error
                        }
                    ]
                };
            });

            return;
        }

        setFormData(previousFormData => {
            return {
                ...previousFormData,
                submitting: true,
                errors: []
            };
        });

        

        props.onSubmit(formData, (response) => {
            

            if (response) {
                discardContent();

                if (props.popup) {
                    props.popup.hide();
                }
            } else {
                
            }

            setFormData(previousFormData => {
                return {
                    ...previousFormData,
                    submitting: false
                };
            });
        });
    };

    const handleTextChange = (e) => {
        // e can be default event or user generated with only target and value properties
        if (e.persist) {
            e.persist();
        }

        setFormData(previousFormData => {
            return {
                ...previousFormData,
                text: e.target.value
            };
        });

        
    };

    const addUploadableMedia = (data) => {
        

        // only add video data if user didn't cancel
        if (data.length > 0) {
            // only add video if size is not higher than maximum allowed
            const videoData = data[0],
                videoSizeInMB = videoData.file.size / (1024 * 1024);

            // only add photo if file extension is allowed
            const extensionAllowed = yipnyap_constants.settings.media_video_allowed_extensions.includes(videoData.extension);

            // if photo extension is not allowed, add error
            if (!extensionAllowed) {
                setFormData(previousFormData => {
                    return {
                        ...previousFormData,
                        errors: [
                            {
                                text: `"${videoData.file.name}" ${yipnyap_translation.file_extension_is_not_allowed}.`
                            }
                        ]
                    };
                });
                // if video size is higher than allowed, show error
            } else if (videoSizeInMB > yipnyap_constants.settings.media_video_upload_maximum_size) {
                setFormData(previousFormData => {
                    return {
                        ...previousFormData,
                        errors: [
                            {
                                text: `"${videoData.file.name}" ${yipnyap_translation.size_is_too_big} (${Number.parseFloat(videoSizeInMB).toFixed(2)}MB).`
                            },
                            {
                                text: `${yipnyap_translation.maximum_size_accepted_is} ${yipnyap_constants.settings.media_video_upload_maximum_size}MB.`
                            }
                        ]
                    };
                });
            } else {
                setFormData(previousFormData => {
                    return {
                        ...previousFormData,
                        uploadable_media: data,
                        errors: []
                    };
                });
            }
        }
    };

    return (
        <div ref={props.forwardedRef} className={`quick-post ${formData.submitting ? 'disabled' : ''}`}>
            <div className="quick-post-header">
                <div className="quick-post-header-filters-wrap">
                    {/* QUICK POST HEADER TITLE */}
                    <p className="quick-post-header-title">{yipnyap_translation.upload_video}</p>
                    {/* QUICK POST HEADER TITLE */}
                </div>
            </div>

            {/* QUICK POST BODY */}
            <div className="quick-post-body">
                <form className={`form ${formData.submitting ? 'disabled' : ''}`}>
                    <div className="form-row">
                        <div className="form-item">
                            <ExpandableTextarea name='text'
                                                value={formData.text}
                                                maxLength={yipnyap_constants.settings.activity_character_limit}
                                                minHeight={120}
                                                placeholder={`${yipnyap_translation.activity_form_placeholder_1} ${props.user.username}! ${yipnyap_translation.activity_form_placeholder_2}`}
                                                userFriends={props.user.friends}
                                                handleChange={handleTextChange}
                                                loading={formData.submitting}
                                                disabled={formData.submitting}
                            />
                        </div>
                    </div>
                </form>

                {
                    (formData.uploadable_media.length > 0) &&
                    <VideoPreview src={formData.uploadable_media[0].url}/>
                }
            </div>
            {/* QUICK POST BODY */}

            {/* QUICK POST FOOTER WRAP */}
            <div className="quick-post-footer-wrap">
                {
                    formData.errors.length > 0 &&
                    <div className="quick-post-footer-errors">
                        {
                            formData.errors.map((error, i) => {
                                return (
                                    <p key={i}
                                       className="quick-post-footer-error error-field-message">* {error.text}</p>
                                );
                            })
                        }
                    </div>
                }

                {/* QUICK POST FOOTER */}
                <div className="quick-post-footer">
                    {/* QUICK POST FOOTER ACTIONS */}
                    <div className="quick-post-footer-actions">
                        <UploadVideoButton onSelect={addUploadableMedia}/>
                    </div>
                    {/* QUICK POST FOOTER ACTIONS */}

                    {/* QUICK POST FOOTER ACTIONS */}
                    <div className="quick-post-footer-actions">
                        <p className="button small void" onClick={discardContent}>{yipnyap_translation.discard}</p>
                        <p className="button small primary"
                           onClick={submitContent}>{yipnyap_translation.post_action}</p>
                    </div>
                    {/* QUICK POST FOOTER ACTIONS */}
                </div>
                {/* QUICK POST FOOTER */}
            </div>
            {/* QUICK POST FOOTER WRAP */}
        </div>
    );
}

export {ActivityVideoUploadForm as default};
