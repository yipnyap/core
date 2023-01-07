import React, {useRef} from 'react';

import AsyncCommentList from './AsyncCommentList';

import {ActivityReactionable} from '../utils/reaction';

import {reorderComments} from '../utils/comment/comment-data';

import {deepExtend} from '../../../utils/core';

import * as activityRouter from '../../../router/activity/activity-router';

function ActivityCommentList(props) {
    const order = props.order ? props.order : 'DESC';
    const comments = useRef(reorderComments(props.comments.slice(), order));

    const createComment = (commentData, callback) => {
        const config = {
            activityID: props.activityID
        };

        deepExtend(config, commentData);

        

        activityRouter.createActivityComment(config, (response) => {
            if (response) {
                props.updateCommentCount(1);
            }

            callback(response);
        });
    };

    const updateComment = (commentData) => {
        const config = {
            id: commentData.id,
            component: commentData.component,
            type: commentData.type,
            user_id: commentData.author.id,
            content: commentData.content,
            recorded_time: commentData.date,
            item_id: commentData.item_id,
            secondary_item_id: commentData.secondary_item_id
        };

        

        return activityRouter.updateActivity(config);
    };

    const getComment = (commentID, callback) => {
        const config = {
            display_comments: 'stream',
            in: commentID,
            filter: {
                action: 'activity_comment'
            }
        };

        activityRouter.getActivities(config, (response) => {
            const comment = response.activities.length > 0 ? response.activities[0] : {};

            callback(comment);
        });
    };

    const getComments = (callback, options) => {
        const startPosition = (options.page - 1) * props.perPage,
            endPosition = startPosition + props.perPage,
            newComments = comments.current.slice(startPosition, endPosition);

        
        
        

        callback(newComments);
    };

    const getCommentCount = (callback) => {
        

        callback(comments.current.length);
    };

    const deleteComment = (config) => {
        return activityRouter.deleteActivityComment({activity_id: props.activityID, comment_id: config.comment_id});
    };

    return (
        <AsyncCommentList postType="activity"
                          getComment={getComment}
                          getComments={getComments}
                          commentCount={comments.current.length}
                          getCommentCount={getCommentCount}
                          createComment={createComment}
                          updateComment={updateComment}
                          deleteComment={deleteComment}
                          user={props.user}
                          order={order}
                          replyType={props.replyType}
                          formPosition={props.formPosition}
                          entityData={(id) => ({activity_id: id})}
                          parentData={props.parentData}
                          reactions={props.reactions}
                          reactionable={ActivityReactionable}
                          showVerifiedBadge={yipnyap_constants.plugin_active['bp-verified-member'] && yipnyap_constants.settings.bp_verified_member_display_badge_in_activity_stream}
        />
    );
}

export {ActivityCommentList as default};
