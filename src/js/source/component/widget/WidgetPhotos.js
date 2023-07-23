import React, {useState, useEffect} from 'react';

import PictureItemList from '../picture/PictureItemList';

import LoaderSpinner from '../loader/LoaderSpinner';

import * as userRouter from '@legacy/router/user/user-router';
import * as memberRouter from '@legacy/router/member/member-router';
import * as groupRouter from '@legacy/router/group/group-router';
import * as activityRouter from '@legacy/router/activity/activity-router';
import * as reactionRouter from '@legacy/router/reaction/reaction-router';

import {updateActivities} from '@legacy/component/utils/activity/activity-data';

function WidgetPhotos(props) {
    const [photos, setPhotos] = useState([]);
    const [photosUser, setPhotosUser] = useState(false);
    const [photosGroup, setPhotosGroup] = useState(false);

    const [loggedUser, setLoggedUser] = useState(false);

    const [reactions, setReactions] = useState([]);

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        getLoggedInMember();
        getReactions();

        if (props.userID) {
            getPhotosUser();
        }

        if (props.groupID) {
            getPhotosGroup();
        }

        getPhotos();
    }, []);

    const getLoggedInMember = () => {
        const userScope = props.groupID ? 'user-status-groups' : 'user-status';

        userRouter.getLoggedInMember(userScope)
            .done((loggedUser) => {
                

                setLoggedUser(loggedUser);
            });
    };

    const getPhotosUser = () => {
        memberRouter.getMembers({include: [props.userID]})
            .done((response) => {
                

                setPhotosUser(response[0]);
            });
    };

    const getPhotosGroup = () => {
        groupRouter.getGroups({include: [props.groupID]})
            .done((response) => {
                

                setPhotosGroup(response[0]);
            });
    };

    const getPhotos = () => {
        const filters = {
            per_page: 12,
            filter: {
                object: props.userID ? 'activity' : 'groups',
                action: 'activity_media'
            }
        };

        if (props.userID) {
            filters.filter.primary_id = props.userID;
        }

        if (props.groupID) {
            filters.filter.primary_id = props.groupID;
        }

        activityRouter.getActivities(filters, (response) => {
            

            setPhotos(response.activities);
            setLoading(false);
        });
    };

    const getReactions = () => {
        reactionRouter.getReactions()
            .done((response) => {
                

                setReactions(response);
            });
    };

    const onActivityUpdate = (newActivityData) => {
        

        setPhotos(previousActivities => {
            return updateActivities(previousActivities, newActivityData);
        });
    };

    return (
        <div className="widget-box">
            {/* WIDGET BOX TITLE */}
            <p className="widget-box-title">{yipnyap_translation.photos}</p>
            {/* WIDGET BOX TITLE */}

            {/* WIDGET BOX CONTENT */}
            <div className="widget-box-content">
                {
                    loading &&
                    <LoaderSpinner/>
                }
                {
                    !loading && (photos.length) > 0 &&
                    <PictureItemList data={photos}
                                     loggedUser={loggedUser}
                                     user={props.userID ? photosUser : photosGroup}
                                     reactions={reactions}
                                     modifiers='small'
                                     displayMax={12}
                                     onActivityUpdate={onActivityUpdate}
                    />
                }
                {
                    !loading && (photos.length === 0) &&
                    <p className="no-results-text">{yipnyap_translation.no_photos_found}</p>
                }
            </div>
            {/* WIDGET BOX CONTENT */}
        </div>
    );
}

export {WidgetPhotos as default};
