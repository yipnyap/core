import React, {useState, useRef, useEffect} from 'react';

import IconSVG from '../icon/IconSVG';

function ActivityFilterBar(props) {
    const [action, setAction] = useState('all');
    const [filters, setFilters] = useState({
        scope: props.hideFollowing ? false : 'myfollowing',
        filter: {}
    });

    const mounting = useRef(true);

    useEffect(() => {
        if (!mounting.current) {
            props.onFiltersChange(filters);
        } else {
            mounting.current = false;
        }
    }, [filters]);

    console.log(filters.scope);

    const setScopeAll = () => {
        changeScope(false);
    };
    const setScopeMentions = () => {
        changeScope('mentions');
    };
    const setScopeFavorites = () => {
        changeScope('favorites');
    };
    const setScopeFriends = () => {
        changeScope('friends');
    };
    const setScopeFollowing = () => {
        changeScope('myfollowing');
    };
    const setScopeGroups = () => {
        changeScope('groups');
    };

    const changeScope = (newScope) => {
        // if scope didn't change, return
        if (newScope === filters.scope) {
            return;
        }

        const newFilters = {
            ...filters,
            scope: newScope
        };

        setFilters(newFilters);
    };

    const handleScopeChange = (e) => {
        const value = e.target.value === 'false' ? false : e.target.value;

        changeScope(value);
    };

    const handleActionChange = (e) => {
        const actionValue = e.target.value,
            filter = actionValue === 'all' ? {} : {action: actionValue};

        setAction(actionValue);

        setFilters({
            ...filters,
            filter: filter
        });
    };

    return (
        <div className={`quick-filters ${window.location.pathname.indexOf('activity') >-1 ? 'top-20 z-10' : ''}`}>
            {/* QUICK FILTERS TABS */}
            <div className="quick-filters-tabs">
                {
                    !props.hideFollowing &&
                    <p className={`quick-filters-tab ${filters.scope === 'myfollowing' ? 'active' : ''}`}
                       onClick={setScopeFollowing}>{yipnyap_translation.following}</p>
                }

                <p className={`quick-filters-tab ${!filters.scope ? 'active' : ''}`} onClick={setScopeAll}>
                    {yipnyap_translation.everything}
                </p>

                {
                    !props.hideSecondaryFilters &&
                    <React.Fragment>
                        <p className={`quick-filters-tab ${filters.scope === 'favorites' ? 'active' : ''}`}
                           onClick={setScopeFavorites}>
                            {yipnyap_translation.favorites}
                        </p>
                        {
                            yipnyap_constants.plugin_active.buddypress_friends &&
                            <p className={`quick-filters-tab ${filters.scope === 'friends' ? 'active' : ''}`}
                               onClick={setScopeFriends}>
                                {yipnyap_translation.friends}
                            </p>
                        }
                        {
                            yipnyap_constants.plugin_active.buddypress_groups && !props.hideGroupsFilter &&
                            <p className={`quick-filters-tab ${filters.scope === 'groups' ? 'active' : ''}`}
                               onClick={setScopeGroups}>
                                {yipnyap_translation.groups}
                            </p>
                        }
                    </React.Fragment>
                }
            </div>
            {/* /QUICK FILTERS TABS */}

            {/* QUICK FILTERS FORM */}
            <form className="quick-filters-form quick-filters-form-mobile">
                <div className="form-row">
                    <div className="form-item">
                        <div className="form-select">
                            <label htmlFor="activity-scope">{yipnyap_translation.scope}</label>
                            <select id="activity-scope" name="scope" value={filters.scope} onChange={handleScopeChange}>
                                <option value="false">{yipnyap_translation.all_updates}</option>
                                {
                                    !props.hideSecondaryFilters &&
                                    <React.Fragment>
                                        <option value="mentions">{yipnyap_translation.mentions}</option>
                                        <option value="favorites">{yipnyap_translation.favorites}</option>
                                        {
                                            yipnyap_constants.plugin_active.buddypress_friends &&
                                            <option value="friends">{yipnyap_translation.friends}</option>
                                        }
                                        {
                                            yipnyap_constants.plugin_active.buddypress_groups && !props.hideGroupsFilter &&
                                            <option value="groups">{yipnyap_translation.groups}</option>
                                        }
                                    </React.Fragment>
                                }
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            {/* QUICK FILTERS FORM */}

            {/* QUICK FILTERS FORM */}
            <form className="quick-filters-form">
                <div className="form-row">
                    <div className="form-item">
                        <div className="form-select">
                            <label htmlFor="activity-show">{yipnyap_translation.show}</label>
                            <select id="activity-show" name="action" value={action} onChange={handleActionChange}>
                                <option value="all">{yipnyap_translation.everything}</option>
                                <option value="activity_update">{yipnyap_translation.status}</option>
                                <option value="activity_share,post_share">{yipnyap_translation.shares}</option>
                                {
                                    yipnyap_constants.plugin_active.vkmedia &&
                                    <React.Fragment>
                                        {
                                            yipnyap_constants.settings.media_photo_upload_enabled && yipnyap_constants.settings.media_video_upload_enabled &&
                                            <option
                                                value="activity_media_update,activity_media_upload,activity_video_update,activity_video_upload">{yipnyap_translation.media}</option>
                                        }
                                        {
                                            yipnyap_constants.settings.media_photo_upload_enabled &&
                                            <option
                                                value="activity_media_update,activity_media_upload">{yipnyap_translation.photos}</option>
                                        }
                                        {
                                            yipnyap_constants.settings.media_video_upload_enabled &&
                                            <option
                                                value="activity_video_update,activity_video_upload">{yipnyap_translation.videos}</option>
                                        }
                                    </React.Fragment>
                                }
                                {
                                    yipnyap_constants.plugin_active.buddypress_friends &&
                                    <option value="friendship_created">{yipnyap_translation.friendships}</option>
                                }
                                {
                                    yipnyap_constants.plugin_active.buddypress_groups &&
                                    <option value="created_group">{yipnyap_translation.new_groups}</option>
                                }
                                {
                                    yipnyap_constants.plugin_active.bbpress &&
                                    <React.Fragment>
                                        <option value="bbp_topic_create">{yipnyap_translation.forum_topics}</option>
                                        <option value="bbp_reply_create">{yipnyap_translation.forum_replies}</option>
                                    </React.Fragment>
                                }
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            {/* QUICK FILTERS FORM */}
        </div>
    );
}

export {ActivityFilterBar as default};
