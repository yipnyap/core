/**
 * TODO: HOLY SHIT REMAKE THIS. PERIOD. FULLY. THIS IS A MESS. I'M SORRY. NOT REALLY. BUT I AM.
 */

import React, {useState, useRef, useEffect} from 'react';
import Paginator from '@legacy/component/utils/Paginator';
import ActivityForm from './activity-form/ActivityForm';
import ActivityFilterBar from './ActivityFilterBar';
import ActivityList from './ActivityList';
import Notification from '../notification/Notification';
import Loader from '../loader/Loader';
import ScrollPager from '../pager/ScrollPager';
import {deepExtend, deepMerge} from '@legacy/utils/core';

import * as activityRouter from '@legacy/router/activity/activity-router';
import * as reactionRouter from '@legacy/router/reaction/reaction-router';

import {filterActivityContentForSave} from '@legacy/component/utils/activity/activity-filter';
import {updateActivities} from '@legacy/component/utils/activity/activity-data';
import {getMemberGroups} from "@legacy/router/v2/members/get";
import {useNotification} from "@nextgen2/providers/Notification.provider";

function ActivityFilterableList(props) {
    const [activities, setActivities] = useState({
        items: [],
        initialFetch: true,
        moreItems: true
    });

    const [pinnedActivityID, setPinnedActivityID] = useState(false);
    const [reactions, setReactions] = useState([]);
    const [fetchingUser, setFetchingUser] = useState(false);
    const [loggedUser, setLoggedUser] = useState(yipnyap_constants.currentUser || false);
    const [hasCheckedLoggedUser, setHasCheckedLoggedUser] = useState(false);
    const [, addNotification] = useNotification();

    const currentPage = useRef(1);
    const createCount = useRef(0);
    const deleteCount = useRef(0);
    const preloadedActivities = useRef(null);
    const filters = useRef({
        per_page: props.perPage,
        sort: props.order,
        show_hidden: false,
        scope: 'myfollowing',
        filter: {}
    });

    useEffect(() => {
        filters.current.show_hidden = props.groupID !== undefined && parseInt(props.groupID) > 0;

        if (props.activityID) {
            filters.current.in = props.activityID;
        }

        if (!props.noFilter) {
            filters.current.filter.object = [
                'activity',
                'profile',
                // 'gamipress'
            ];

            filters.current.filter.action = [
                'activity_update',
                'activity_share',
                'post_share',
                // 'new_avatar',
                'new_member'
            ];

            // add group activity object and actions if the BuddyPress groups component is active
            if (yipnyap_constants.plugin_active.buddypress_groups) {
                filters.current.filter.object.push('groups');
                // filters.current.filter.action.push('created_group', 'joined_group');
            }

            // add friend activity object and actions if the BuddyPress friends component is active
            if (yipnyap_constants.plugin_active.buddypress_friends) {
                filters.current.filter.object.push('friends');
                // filters.current.filter.action.push('friendship_created');
            }

            // add vkmedia activity actions if the plugin is active
            if (yipnyap_constants.plugin_active.vkmedia) {
                filters.current.filter.action.push('activity_media_update', 'activity_media_upload');
                filters.current.filter.action.push('activity_video_update', 'activity_video_upload');
            }

            // add bbpress activity object and actions if the plugin is active
            if (yipnyap_constants.plugin_active.bbpress) {
                filters.current.filter.object.push('bbpress');
                filters.current.filter.action.push('bbp_topic_create', 'bbp_reply_create');
            }
        }
    }, []);

    const onFiltersChange = (newFilters) => {
        deepExtend(filters.current, newFilters);

        if (typeof filters.current.filter.action === 'undefined') {
            filters.current.filter.action = [
                'activity_update',
                'activity_share',
                'post_share'
            ];

            // add vkmedia activity actions if the plugin is active
            if (yipnyap_constants.plugin_active.vkmedia) {
                filters.current.filter.action.push('activity_media_update', 'activity_media_upload');
                filters.current.filter.action.push('activity_video_update', 'activity_video_upload');
            }

            // add bbpress activity actions if the plugin is active
            if (yipnyap_constants.plugin_active.bbpress) {
                filters.current.filter.action.push('bbp_topic_create', 'bbp_reply_create');
            }
        }

        filters.current.filter.object = [
            'activity',
            'profile',
            // 'gamipress'
        ];

        // add group activity object if the BuddyPress groups component is active
        if (yipnyap_constants.plugin_active.buddypress_groups) {
            filters.current.filter.object.push('groups');
        }

        // add friend activity object if the BuddyPress friends component is active
        if (yipnyap_constants.plugin_active.buddypress_friends) {
            filters.current.filter.object.push('friends');
        }

        // add bbpress activity object if the plugin is active
        if (yipnyap_constants.plugin_active.bbpress) {
            filters.current.filter.object.push('bbpress');
        }


        reloadActivities();
    };

    const getActivities = (callback, options = {}) => {
        // get next page to fetch based on create and delete counts
        currentPage.current = Paginator.getNextPageToFetch({
            page: currentPage.current,
            per_page: props.perPage,
            createCount: createCount.current,
            deleteCount: deleteCount.current
        });

        // reset counts
        createCount.current = 0;
        deleteCount.current = 0;

        const config = {
            page: currentPage.current
        };

        deepExtend(config, filters.current);
        deepExtend(config, options);

        // get activities of this user only
        if (props.userID) {
            config.filter.user_id = props.userID;

            if (currentPage.current === 1) {
                config.include_pinned_from = props.userID;
            }
        }

        // get activities of this group only
        if (props.groupID) {
            config.filter.primary_id = props.groupID;
            config.filter.object = 'groups';
        }

        if (props.activityID) {
            filters.current.in = props.activityID;
        }

        if (props.userID || props.groupID || props.activityID) {
            // undo the "myfollowing" scope
            config.scope = config.scope === 'myfollowing' ? 'false' : config.scope;
        }


        activityRouter.getActivities(config, callback);
    };

    const reloadActivities = () => {
        currentPage.current = 1;

        // reset counts
        createCount.current = 0;
        deleteCount.current = 0;

        setActivities({
            items: [],
            initialFetch: true,
            moreItems: true
        });

        getActivitiesPage();
    };

    const preloadActivities = (options, scope) => {
        const preloadedActivities = jQuery.Deferred();

        getActivities((response) => {


            // cancel if scope changed
            const newScope = filters.current.scope;

            if (newScope !== scope) {
                preloadedActivities.resolve([], false);
                return;
            }

            currentPage.current += 1;

            const activitiesWithoutDuplicates = Paginator.removeDuplicates(activities.items, response.activities, 'id');

            preloadedActivities.resolve(activitiesWithoutDuplicates, response.has_more_items);
        }, options);

        return preloadedActivities.promise();
    };

    const getActivitiesPage = (callback = () => {
    }) => {
        const scope = filters.current.scope;

        // exclude pinned activity if exists
        const options = pinnedActivityID ? { exclude: pinnedActivityID } : {};

        if (currentPage.current === 1) {
            getActivities((response) => {
                if (!response.activities) {
                    addNotification({
                        type: 'error',
                        title: 'Failed to load group',
                        message: response.data,
                        persistent: true,
                        doNotStack: true,
                    })
                    setLoggedUser(false);
                    throw new Error(`Failed to load group: ${response.data}`);
                }

                // cancel if scope changed
                const newScope = filters.current.scope;

                if (newScope !== scope) {
                    callback(false);
                    return;
                }

                currentPage.current += 1;

                if ((response.activities.length > 0) && response.activities[0].pinned) {
                    setPinnedActivityID(response.activities[0].id);
                    // exclude pinned activity for next preload
                    options.exclude = response.activities[0].id;
                }

                setActivities(previousActivities => {
                    const activitiesWithoutDuplicates = Paginator.removeDuplicates(previousActivities.items, response.activities, 'id');

                    return {
                        items: previousActivities.items.concat(activitiesWithoutDuplicates),
                        moreItems: response.has_more_items,
                        initialFetch: false
                    };
                });

                callback(response.has_more_items);

                // preload next page activities
                preloadedActivities.current = preloadActivities(options, filters.current.scope);
            }, options);
        } else {
            // dump preloaded activities and preload next page if it has more items
            preloadedActivities.current
                .done((activities, hasMoreItems) => {


                    setActivities(previousActivities => {
                        return {
                            ...previousActivities,
                            items: previousActivities.items.concat(activities),
                            moreItems: hasMoreItems
                        };
                    });

                    callback(hasMoreItems);

                    // preload next page if it has more items
                    if (hasMoreItems) {
                        // preload next page activities
                        preloadedActivities.current = preloadActivities(options, filters.current.scope);
                    }
                });
        }
    };

    const createActivity = (data, callback) => {


        const itemID = Number.parseInt(data.postIn, 10);

        // post public by default
        let hideSitewide = false;

        // if posting to a group, get group privacy to set hideSitewide
        if (itemID !== 0) {
            for (const group of loggedUser.groups) {
                // user is a member of the group
                if (group.id === itemID) {
                    // hide sitewide if not public group
                    hideSitewide = group.status !== 'public';
                    break;
                }
            }
        }

        let uploadable_media = false;

        if (data.uploadable_media) {
            const component = itemID === 0 ? 'member' : 'group',
                componentID = component === 'member' ? loggedUser.id : itemID,
                files = [];

            for (const media of data.uploadable_media) {
                files.push(media.file);
            }

            uploadable_media = {
                files: files,
                component: {
                    type: component,
                    id: componentID,
                    uploader_id: loggedUser.id
                }
            };
        }

        let activityType = 'activity_update';

        if (uploadable_media) {
            if (data.uploadable_media_type === 'image') {
                activityType = 'activity_media_update';
            } else if (data.uploadable_media_type === 'video') {
                activityType = 'activity_video_update';
            }
        }

        const tags = data.hashtags;
        let activityContent = filterActivityContentForSave(data.text);

        // Search and remove tags inside activityContent
        if (tags?.length > 0) {
            tags.map((tag, i) => {
                activityContent = activityContent.replace(tag, '');
                tags[i] = tag.replace('#', '');
            })
        }

        const activityData = {
            creation_config: {
                item_id: itemID,
                user_id: loggedUser.id,
                component: itemID === 0 ? 'activity' : 'groups',
                type: activityType,
                content: activityContent,
                tags: tags || false,
                hide_sitewide: hideSitewide,
                label: (data.label ? data.label.value : null)
            },
            attached_media: data.attached_media,
            uploadable_media: uploadable_media,
            uploadable_media_type: data.uploadable_media_type
        };


        activityRouter.createActivity(activityData, (response) => {


            // activity created
            if (response) {
                onCreatedActivity(response, itemID, callback);
            } else {
                callback(response);
            }
        });
    };

    const onCreatedActivity = (activityID, itemID, callback) => {
        createCount.current += 1;

        const postedInMyProfile = loggedUser.id === props.userID,
            postedInMyGroup = itemID === props.groupID,
            postedInNewsfeed = !props.userID;

        // if activity created and logged user is viewing newsfeed, its own profile or the group where he is posting
        // get created activity for display
        if (postedInNewsfeed || postedInMyProfile || postedInMyGroup) {
            // get created activity using current filters, if the created activity returns then prepend it
            // otherwise it shouldn't be displayed with current filters
            const getCreatedActivityFilters = deepMerge(filters.current);
            // limit to created activity id
            getCreatedActivityFilters.in = activityID;

            activityRouter.getActivities(getCreatedActivityFilters, (createdActivityResponse) => {


                if (createdActivityResponse.activities.length) {
                    const createdActivity = createdActivityResponse.activities[0];

                    // add activity to state activities
                    setActivities(previousActivities => {
                        const newActivities = previousActivities.items.slice();

                        newActivities.unshift(createdActivity);

                        return {
                            ...previousActivities,
                            items: newActivities
                        };
                    });
                }

                callback(activityID);
            });
        }
    };

    const updateActivity = (data, callback) => {


        const activityUpdatePromise = activityRouter.updateActivity(data);

        activityUpdatePromise
            .done((response) => {


                // activity updated successfully
                if (response) {
                    // fetch the updated activity
                    const getUpdatedActivityFilters = {
                        in: data.id
                    };

                    activityRouter.getActivities(getUpdatedActivityFilters, (updatedActivityResponse) => {


                        if (updatedActivityResponse.activities.length) {
                            const updatedActivity = updatedActivityResponse.activities[0];

                            onActivityUpdate(updatedActivity);
                        }

                        callback();
                    });
                }
            });
    };

    const deleteActivity = (activity_id, callback) => {


        activityRouter.deleteActivity(activity_id, (response) => {


            callback(response);

            // activity deleted
            if (response) {
                deleteCount.current += 1;

                // remove from state activities
                setActivities(previousActivities => {
                    const newActivities = previousActivities.items.filter((activity) => {
                        return activity.id !== activity_id;
                    });

                    return {
                        ...previousActivities,
                        items: newActivities
                    };
                });
            }
        });
    };

    const pinActivity = (activityID, callback) => {


        const config = {
            userID: loggedUser.id,
            activityID: activityID
        };

        activityRouter.pinActivity(config, (response) => {


            if (response) {
                setPinnedActivityID(activityID);
            }

            callback();
        });
    };

    const unpinActivity = (callback) => {


        const config = {
            userID: loggedUser.id
        };

        activityRouter.unpinActivity(config, (response) => {


            if (response) {
                setPinnedActivityID(false);
            }

            callback();
        });
    };

    const getLoggedUser = (callback = () => {}) => {
        // Get current user groups
        getMemberGroups(yipnyap_constants.currentUser?.id).then(r => {
            setLoggedUser(yipnyap_constants.currentUser);
            setFetchingUser(false);
            setHasCheckedLoggedUser(true);
            callback(yipnyap_constants.currentUser);
        });
    };

    const onPlay = (activityID = false) => {
        setActivities(previousActivities => {
            const activities = previousActivities.items.slice();


            for (const activity of activities) {
                if (activity.meta && activity.meta.attached_media_type && (activity.meta.attached_media_type[0] === 'youtube')) {
                    // stop all videos if activityID is not set
                    if (!activityID) {
                        activity.meta.attached_media_stop = !activity.meta.attached_media_stop;
                        // stop all other videos if activityID is set
                    } else if (activity.id !== activityID) {
                        activity.meta.attached_media_stop = !activity.meta.attached_media_stop;
                    }
                }
            }


            return {
                ...previousActivities,
                items: activities
            };
        });
    };

    const getReactions = () => {
        if (yipnyap_constants.plugin_active.vkreact && yipnyap_constants.plugin_active['vkreact-buddypress']) {
            reactionRouter.getReactions()
                .done((response) => {


                    setReactions(response);
                });
        }
    };

    const onActivityUpdate = (newActivityData) => {


        setActivities(previousActivities => {
            return {
                ...previousActivities,
                items: updateActivities(previousActivities.items, newActivityData)
            };
        });
    };

    useEffect(() => {
        getLoggedUser(() => {
            getReactions();
            getActivitiesPage();
        });
    }, []);

    // Check if groupID has changed, if so, reset activities and get new ones
    const usePrevious = value => {
        const ref = useRef();
        useEffect(() => {
            ref.current = value;
        });
        return ref.current;
    };

    const prevGroupID = usePrevious(props.groupID);
    useEffect(() => {
        if(props.groupID !== prevGroupID) {
            onFiltersChange({
                scope: false,
                filter: {}
            })
        }
    }, [props]);

    let postInDefault = '0';

    // if user is logged in and viewing a group activity feed
    if (loggedUser && props.groupID) {
        // check if the user is a member of the group and set the default post option to that group
        for (const group of loggedUser.groups) {
            // user is a member of the group
            if (group.id === props.groupID) {
                postInDefault = group.id + '';
                break;
            }
        }
    }

    const onNewsfeed = loggedUser && !props.userID && !props.groupID && !props.activityID,
        ownProfile = loggedUser && (loggedUser.id === props.userID),
        onGroupNewsfeed = loggedUser && props.groupID,
        ownGroup = onGroupNewsfeed && loggedUser.groups.some((group) => !group.is_banned && (group.id === props.groupID));

    return (
        <div className={`grid-legacy ${props.className}`}>
            {
                fetchingUser &&
                <Loader/>
            }
            {
                !fetchingUser &&
                <React.Fragment>
                    {
                        (onNewsfeed || ownProfile || ownGroup) &&
                        <ActivityForm user={loggedUser}
                                      postIn={postInDefault}
                                      onSubmit={createActivity}
                        />
                    }
                    {
                        !props.activityID &&
                        <ActivityFilterBar onFiltersChange={onFiltersChange}
                                           hideGroupsFilter={Boolean(props.groupID)}
                                           hideSecondaryFilters={!loggedUser && !props.userID && !props.groupID}
                                           hideFollowing={props.userID || props.groupID || !loggedUser}
                        />
                    }

                    <ScrollPager modifiers="grid-legacy gap-4" loadMoreItems={getActivitiesPage}
                                 moreItems={activities.moreItems}
                                 initialFetch={activities.initialFetch} element={props.element || null}>
                        {
                            (activities.items.length === 0) && !activities.moreItems &&
                            <Notification title={`o((⊙﹏⊙))o we couldn't discover any content`}
                                          text={`New to Yipnyap? Go hit "Everything" and follow those you like!`}
                            />
                            // <>
                            //     <h3 class="text-lg leading-6 font-medium">
                            //         o((⊙﹏⊙))o we couldn't discover content you'd like
                            //     </h3>
                            //     <div class="mt-2 text-sm leading-5 text-gray-500">
                            //         <p>New to Yipnyap? Go explore and follow those you love!</p>
                            //         <p>For now, we'll keep checking in the background.</p>
                            //     </div>
                            // </>

                        }
                        {
                            (activities.items.length > 0) &&
                            <ActivityList data={activities.items}
                                          user={loggedUser}
                                          reactions={reactions}
                                          profileUserID={props.userID}
                                          pinnedActivityID={pinnedActivityID}
                                          pinActivity={pinActivity}
                                          unpinActivity={unpinActivity}
                                          updateActivity={updateActivity}
                                          deleteActivity={deleteActivity}
                                          onShare={onCreatedActivity}
                                          onPlay={onPlay}
                                          onActivityUpdate={onActivityUpdate}
                            />
                        }
                    </ScrollPager>
                </React.Fragment>
            }
        </div>
    );
}

export { ActivityFilterableList as default };
