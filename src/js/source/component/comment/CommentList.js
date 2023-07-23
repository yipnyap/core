import React, {useState} from 'react';

import Comment from './Comment';

import {updateCommentReactions} from '@legacy/component/utils/comment/comment-data';

function CommentList(props) {
    const [deleting, setDeleting] = useState(false);

    const deleteComment = (config) => {
        setDeleting(config.comment_id);

        props.deleteComment(config, (response) => {
            

            if (!response) {
                setDeleting(false);
            }
        });
    };

    const onReplyButtonClick = (commentID) => {
        props.getChildrenComments(commentID);
        props.onReplyButtonClick(commentID);
    };

    const depth = props.depth || 1;

    const replyText = depth === 2 && props.childrenComments > 1 ? yipnyap_translation.replies : yipnyap_translation.reply,
        commentsLeft = props.commentCount - props.comments.length,
        hasMoreComments = commentsLeft > 0;

    const renderedComments = [];

    for (const comment of props.comments) {
        const reactionableProps = {
            entityData: props.entityData(comment.id),
            user: props.user,
            reactions: props.reactions,
            reactionData: comment.reactions,
            onUserReactionUpdate: (newReactionData) => {
                const newCommentData = updateCommentReactions(comment, newReactionData);

                props.onCommentUpdate(newCommentData);
            }
        };

        const reactionable = props.reactionable(reactionableProps);

        renderedComments.push(
            <div className={`post-comment-list ${deleting === comment.id ? 'post-comment-list-deleted' : ''}`}
                 key={comment.id}>
                <Comment data={comment}
                         user={props.user}
                         userCanComment={props.userCanComment}
                         allowGuest={props.allowGuest}
                         onReplyButtonClick={() => {
                             depth === 1 && comment.hasChildren ? onReplyButtonClick(comment.id) : props.onReplyButtonClick(comment.id);
                         }}
                         onCancelReplyButtonClick={props.onCancelReplyButtonClick}
                         createComment={props.createComment}
                         depth={depth}
                         parentData={props.parentData}
                         reactions={props.reactions}
                         reactionData={comment.reactions}
                         userReaction={reactionable.getUserReaction()}
                         createUserReaction={reactionable.createUserReaction}
                         deleteUserReaction={reactionable.deleteUserReaction}
                         postType={props.postType}
                         showVerifiedBadge={props.showVerifiedBadge}
                         updateComment={props.updateComment}
                         deleteComment={deleteComment}
                         disableComments={props.disableComments}
                />
                {
                    (comment.children instanceof Array) &&
                    <CommentList comments={comment.children}
                                 user={props.user}
                                 userCanComment={props.userCanComment}
                                 createComment={props.createComment}
                                 onReplyButtonClick={props.onReplyButtonClick}
                                 onCancelReplyButtonClick={props.onCancelReplyButtonClick}
                                 childrenComments={comment.hasChildren}
                                 getChildrenComments={() => {
                                     props.getChildrenComments(comment.id);
                                 }}
                                 commentCount={comment.children.length}
                                 depth={depth + 1}
                                 entityData={props.entityData}
                                 parentData={props.parentData}
                                 reactions={props.reactions}
                                 reactionable={props.reactionable}
                                 onCommentUpdate={props.onCommentUpdate}
                                 postType={props.postType}
                                 showVerifiedBadge={props.showVerifiedBadge}
                                 updateComment={props.updateComment}
                                 deleteComment={deleteComment}
                                 disableComments={props.disableComments}
                    />
                }
            </div>
        );
    }

    return (
        <div className="post-comment-list-wrap">
            {renderedComments}
            {
                (depth === 1) && hasMoreComments &&
                <p className="post-comment-heading animate-slide-down" onClick={props.getMoreComments}>
                    {yipnyap_translation.load_more_comments} <span className="highlighted">{commentsLeft}</span>
                </p>
            }
            {
                (depth === 2) && props.childrenComments > 0 &&
                <p className={`post-comment-heading animate-slide-down reply-${depth}`}
                   onClick={props.getChildrenComments}>
                    {yipnyap_translation.load} <span className="highlighted">{props.childrenComments}</span> {replyText}...
                </p>
            }
        </div>
    );
}

export {CommentList as default};
