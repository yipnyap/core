import React, {Fragment, useState, useRef, useEffect} from 'react';

import Avatar from '../../avatar/Avatar';

import MediaLinkPreview from '../../media/MediaLinkPreview';
import UploadableMediaList from '../../media/UploadableMediaList';

import BadgeVerified from '../../badge/BadgeVerified';

import ExpandableTextarea from '../../form/ExpandableTextarea';

import UploadVideoButton from '../../video/UploadVideoButton';
import VideoPreview from '../../video/VideoPreview';

import {extractAttachedMedia} from '../../../utils/core';
import {getActivityTemplate} from '../../utils/activity/activity-template';
import {PaperClipIcon, VideoCameraIcon} from "@heroicons/react/solid";
import {PhotographIcon} from "@heroicons/react/outline";

function classNames(...classes) {
    return classes.filter(Boolean).join(' ');
}

const rekkiAudio = new Audio(`${yipnyap_constants.yipnyap_url}/src/sound/rekki.ogg`);

function ActivityForm(props) {
    const [formData, setFormData] = useState({
        text: '',
        postIn: props.postIn ? props.postIn : '0',
        attached_media: false,
        hashtags: false,
        uploadable_media_type: false,
        uploadable_media: false,
        submitting: false,
        errors: []
    });

    // useEffect(() => {
    //     if (!props.shareData && yipnyap_constants.plugin_active.vkmedia && yipnyap_constants.settings.media_photo_upload_enabled) {
    //         createTooltip({
    //             containerElement: photoTooltipRef.current,
    //             offset: 8,
    //             direction: 'top',
    //             animation: {
    //                 type: 'translate-out-fade'
    //             }
    //         });
    //     }
    // }, []);

    const fileID = useRef(1);
    const allowedExtensions = useRef(`.${yipnyap_constants.settings.media_video_allowed_extensions.join(',.')}`);
    const fileInputRef = useRef(null);

    const discardContent = () => {
        setFormData(previousFormData => {
            return {
                ...previousFormData,
                text: '',
                attached_media: false,
                uploadable_media_type: false,
                uploadable_media: false,
                errors: []
            };
        });

        if (props.popup) {
            props.popup.hide();
        }
    };

    const toggleUploadablePhotosBar = () => {
        setFormData(previousFormData => {
            if (previousFormData.uploadable_media && (previousFormData.uploadable_media_type === 'image')) {
                return {
                    ...previousFormData,
                    uploadable_media: false,
                    uploadable_media_type: false,
                    errors: []
                };
            }

            return {
                ...previousFormData,
                uploadable_media: [],
                uploadable_media_type: 'image',
                errors: []
            };
        });
    };

    const submitContent = () => {
        // if already submitting form or not sharing post and no message entered, return
        if (formData.submitting || (!props.shareData && (formData.text === '') && !formData.uploadable_media || (formData.uploadable_media && formData.uploadable_media.length === 0))) {
            setFormData(previousFormData => {
                return {
                    ...previousFormData,
                    errors: [
                        {
                            text: yipnyap_translation.activity_form_empty_error
                        }
                    ]
                };
            });

            return;
        }

        if (formData.text === '!rek') {
            setFormData(previousFormData => {
                return {
                    ...previousFormData,
                    errors: [
                        {
                            text: 'your mother'
                        }
                    ]
                };
            });

            if (!rekkiAudio.paused) {
                rekkiAudio.currentTime = 0;
            } else {
                rekkiAudio.play();
            }
            return;
        }

        setFormData(previousFormData => {
            return {
                ...previousFormData,
                hashtags: false,
                submitting: true,
                errors: []
            };
        });

        console.log('ACTIVITY FORM - POST CONTENT: ', formData);

        props.onSubmit(formData, (response) => {
            console.log('ACTIVITY FORM - CREATED ACTIVITY: ', response);

            if (response) {
                discardContent();

                if (props.popup) {
                    props.popup.hide();
                }
            } else {
                console.log('ACTIVITY FORM - ERROR CREATING ACTIVITY');
            }

            setFormData(previousFormData => {
                return {
                    ...previousFormData,
                    hashtags: false,
                    submitting: false
                };
            });
        });
    };

    const resetAttachedMedia = () => {
        setFormData(previousFormData => {
            return {
                ...previousFormData,
                attached_media: false
            };
        });
    };

    const handlePostInChange = (e) => {
        e.persist();

        setFormData(previousFormData => {
            return {
                ...previousFormData,
                postIn: e.target.value
            };
        });
    };

    const handleTextChange = (e) => {
        // check if there is a media link in the text content
        const attached_media = extractAttachedMedia(e.target.value);

        // e can be default event or user generated with only target and value properties
        if (e.persist) {
            e.persist();
        }

        console.log('ACTIVITY FORM - EXTRACTED ATTACHED MEDIA: ', attached_media);

        setFormData(previousFormData => {
            return {
                ...previousFormData,
                text: e.target.value,
                attached_media: attached_media,
                hashtags: e.target.value.match(/#\S+/g) ?? false
            };
        });
    };

    const uploadVideo = () => {
        const files = fileInputRef.current.files;

        console.log('UPLOAD VIDEO BUTTON - UPLOAD FILES: ', files);

        const fileData = [];

        for (const file of files) {
            const fileExtension = file.name.substring(file.name.lastIndexOf('.') + 1);

            fileData.push({
                id: fileID.current,
                file: new File([file], file.name),
                url: URL.createObjectURL(file),
                extension: fileExtension
            });

            fileID.current += 1;
        }

        console.log('UPLOAD VIDEO BUTTON - FILE DATA: ', fileData);

        addUploadableVideo(fileData);
    };

    const addUploadableVideo = (data) => {
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
                        uploadable_media_type: 'video',
                        errors: []
                    };
                });
            }
        }
    };

    const addUploadableMedia = (data) => {
        console.log('ACTIVITY FORM - ADD UPLOADABLE MEDIA: ', data);

        // only add photos data if user didn't cancel
        if (data.length > 0) {
            const errors = [],
                photosData = [];

            let fileSizeError = false;

            for (const photoData of data) {
                // only add photo if size is not higher than maximum allowed
                const photoSizeInMB = photoData.file.size / (1024 * 1024);

                // only add photo if file extension is allowed
                const extensionAllowed = yipnyap_constants.settings.media_photo_allowed_extensions.includes(photoData.extension);

                // if photo extension is not allowed, add error
                if (!extensionAllowed) {
                    errors.push({
                        text: `"${photoData.file.name}" ${yipnyap_translation.file_extension_is_not_allowed}.`
                    });
                    // if photo size is higher than allowed, add error
                } else if (photoSizeInMB > yipnyap_constants.settings.media_photo_upload_maximum_size) {
                    fileSizeError = true;

                    errors.push({
                        text: `"${photoData.file.name}" ${yipnyap_translation.size_is_too_big} (${Number.parseFloat(photoSizeInMB).toFixed(2)}MB).`
                    });
                } else {
                    photosData.push(photoData);
                }
            }

            if ((errors.length > 0) && fileSizeError) {
                errors.push({
                    text: `${yipnyap_translation.maximum_size_accepted_is} ${yipnyap_constants.settings.media_photo_upload_maximum_size}MB.`
                });
            }

            setFormData(previousFormData => {
                const newUploadableMedia = previousFormData.uploadable_media.concat(photosData);

                console.log('ACTIVITY FORM - UPLOADABLE MEDIA: ', newUploadableMedia);

                return {
                    ...previousFormData,
                    uploadable_media: newUploadableMedia,
                    errors: errors
                };
            });
        }
    };

    const removeUploadableMedia = (id) => {
        console.log('ACTIVITY FORM - REMOVE UPLOADABLE MEDIA: ', id);

        setFormData(previousFormData => {
            const uploadableMedia = previousFormData.uploadable_media.filter((media, i) => {
                if (media.id === id) {
                    // release object URL reference
                    URL.revokeObjectURL(media.url);
                }

                return media.id !== id;
            });

            console.log('ACTIVITY FORM - UPLOADABLE MEDIA: ', uploadableMedia);

            return {
                ...previousFormData,
                uploadable_media: uploadableMedia
            };
        });
    };

    let ActivityFormat = false;

    if (props.shareData) {
        if (props.shareData.format) {
            ActivityFormat = props.shareData.format;
        }
    }

    const ActivityTemplate = props.shareData ? getActivityTemplate(props.shareData.type, ActivityFormat)({
        data: props.shareData,
        simpleActivity: true,
        sharePopupActivity: true,
        user: props.user
    }) : '';

    const displayVerifiedMemberBadge = yipnyap_constants.plugin_active['bp-verified-member'] && yipnyap_constants.settings.bp_verified_member_display_badge_in_activity_stream && props.user.verified;

    const userGroups = props.user.groups.filter(group => !group.is_banned);

    return (
        <div ref={props.forwardedRef} className={`quick-post ${formData.submitting ? 'disabled' : ''}`}>
            <div className="quick-post-header">
                <div className="quick-post-header-filters-wrap">
                    {/* USER STATUS */}
                    <div className="user-status">
                        <div className="user-status-avatar">
                            <Avatar size="small"
                                    data={props.user}
                                    noBorder
                                    noLink
                            />
                        </div>

                        <p className="user-status-title medium">
                            <span className="bold">{props.user.name}</span>
                            {
                                displayVerifiedMemberBadge &&
                                <BadgeVerified/>
                            }
                        </p>
                        <p className="user-status-text small">{yipnyap_translation.status_update}</p>
                    </div>
                    {/* USER STATUS */}

                    {/* QUICK POST HEADER FILTERS */}
                    <form className="quick-post-header-filters">
                        <div className="form-row split">
                            <div className="form-item">
                                <div className="form-select">
                                    <label htmlFor="post-in">{yipnyap_translation.post_in}</label>
                                    <select id="post-in" name="postIn" value={formData.postIn}
                                            onChange={handlePostInChange}>
                                        <option value="0">{yipnyap_translation.my_profile}</option>
                                        {
                                            yipnyap_constants.plugin_active.buddypress_groups &&
                                            userGroups.map((group) => {
                                                return (
                                                    <option key={group.id} value={group.id}>{group.name}</option>
                                                );
                                            })
                                        }
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    {/* QUICK POST HEADER FILTERS */}
                </div>
            </div>

            {/* QUICK POST BODY */}
            <div className={`quick-post-body ${props.shareData ? 'with-share-data' : ''}`}>
                <form className={`form ${formData.submitting ? 'disabled' : ''}`}>
                    <div className="form-row">
                        <div className="form-item">
                            <ExpandableTextarea kind="activity"
                                                name="text"
                                                value={formData.text}
                                                maxLength={yipnyap_constants.settings.activity_character_limit}
                                                minHeight={120}
                                                placeholder={`${yipnyap_translation.activity_form_placeholder_1} ${props.user.name}! ${yipnyap_translation.activity_form_placeholder_2}`}
                                                userFriends={props.user.friends}
                                                handleChange={handleTextChange}
                                                loading={formData.submitting}
                                                disabled={formData.submitting}
                            />
                            <div className="absolute bottom-0 inset-x-px">
                                {/* Actions: These are just examples to demonstrate the concept, replace/wire these up however makes sense for your project. */}
                                <div className="flex flex-wrap justify-end py-2 px-2 space-x-2 sm:px-3">
                                    {
                                        formData.hashtags && formData.hashtags.map((hashtag, i) => (
                                            <span key={i}
                                                  className="mb-2 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                {hashtag}
                                            </span>
                                        ))
                                    }
                                </div>

                                <div
                                    className="px-2 py-2 flex justify-between items-center space-x-3 sm:px-3">
                                    {
                                        yipnyap_constants.settings.media_photo_upload_enabled &&
                                        <div className="flex mr-auto">
                                            <button
                                                type="button"
                                                className="rounded-full px-3 py-2 inline-flex items-center text-left text-gray-400 group"
                                                onClick={toggleUploadablePhotosBar}
                                            >
                                                <PhotographIcon className="-ml-1 h-5 w-5 mr-2 group-hover:text-gray-500"
                                                               aria-hidden="true"/>
                                                <span
                                                    className="text-sm text-gray-500 group-hover:text-gray-600 italic">Photo</span>
                                            </button>

                                            <input ref={fileInputRef}
                                                   className="uploadable-item-selector-input"
                                                   type="file"
                                                   accept={allowedExtensions.current}
                                                   onChange={uploadVideo}
                                            />
                                            <button
                                                type="button"
                                                className="rounded-full px-3 py-2 inline-flex items-center text-left text-gray-400 group"
                                                onClick={() => {
                                                    fileInputRef.current.click();
                                                }}
                                                >
                                                <VideoCameraIcon className="-ml-1 h-5 w-5 mr-2 group-hover:text-gray-500"
                                                                    aria-hidden="true"/>
                                                <span
                                                    className="text-sm text-gray-500 group-hover:text-gray-600 italic">Video</span>
                                            </button>
                                        </div>
                                    }
                                    <div className="flex-shrink-0">
                                        <p className="button small void"
                                           onClick={discardContent}>{yipnyap_translation.discard}</p>
                                    </div>
                                    <div className="flex-shrink-0">
                                        <p
                                            className="ypsdk button-upgrade"
                                            color="primary"
                                            onClick={submitContent}
                                        >
                                            Create
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>

                {
                    formData.attached_media &&
                    <MediaLinkPreview iframeSrc={formData.attached_media.link}
                                      onCloseButtonClick={resetAttachedMedia}
                                      disabled={formData.submitting}
                    />
                }

                {
                    !props.shareData && formData.uploadable_media &&
                    <React.Fragment>
                        {
                            (formData.uploadable_media_type === 'video') &&
                            <VideoPreview src={formData.uploadable_media[0].url}/>
                        }
                        {
                            (formData.uploadable_media_type === 'image') &&
                            <UploadableMediaList data={formData.uploadable_media}
                                                 onSelect={addUploadableMedia}
                                                 onRemove={removeUploadableMedia}
                                                 disabled={formData.submitting}
                            />
                        }
                    </React.Fragment>
                }

                {
                    props.shareData &&
                    <div className="widget-box no-padding">
                        {ActivityTemplate}
                    </div>
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
            </div>
            {/* QUICK POST FOOTER WRAP */}
        </div>
    );
}

export {ActivityForm as default};
