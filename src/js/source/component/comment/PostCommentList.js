import React from 'react';

import AsyncCommentList from './AsyncCommentList';

import {deepExtend} from '@legacy/utils/core';

import * as commentRouter from '@legacy/router/comment/comment-router';

import {PostCommentReactionable} from '@legacy/component/utils/reaction';

function PostCommentList(props) {
    const order = props.order ? props.order : 'DESC';

    const createComment = (commentData, callback) => {
        const config = {
            postID: props.postID
        };

        deepExtend(config, commentData);

        

        commentRouter.createComment(config, (response) => {
            if (response) {
                props.updateCommentCount(1);
            }

            callback(response);
        });
    };

    const updateComment = (commentData) => {
        const config = {
            comment_ID: commentData.id,
            comment_content: commentData.content
        };

        

        return commentRouter.updateComment(config);
    };

    const getComment = (commentID, callback) => {
        const getCommentConfig = {
            comment__in: [commentID]
        };

        commentRouter.getComments(getCommentConfig, (comments) => {
            callback(comments[0]);
        });
    };

    const getComments = (callback, options) => {
        const config = {
            post_id: props.postID,
            paged: options.page,
            number: props.perPage,
            order: order,
            hierarchical: 'threaded',
            status: 'approve'
        };

        commentRouter.getComments(config, callback);
    };

    const getCommentCount = (callback) => {
        commentRouter.getPostTopLevelCommentCount(props.postID, callback);
    };

    return (
        <AsyncCommentList postType="post"
                          getComment={getComment}
                          getComments={getComments}
                          commentCount={props.commentCount}
                          getCommentCount={getCommentCount}
                          createComment={createComment}
                          updateComment={updateComment}
                          deleteComment={commentRouter.deletePostComment}
                          user={props.user}
                          order={order}
                          replyType={props.replyType}
                          formPosition={props.formPosition}
                          entityData={(id) => ({postcomment_id: id})}
                          reactions={props.reactions}
                          reactionable={PostCommentReactionable}
                          disableComments={props.disableComments}
                          showVerifiedBadge={yipnyap_constants.plugin_active['bp-verified-member'] && yipnyap_constants.settings.bp_verified_member_display_badge_in_wp_comments}
        />
    );
}

export {PostCommentList as default};
