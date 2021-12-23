import * as followRouter from '../../router/follow/follow-router';

const followUtils = (loggedUser, userID) => {
    const me = {};

    me.isFollowing = function () {
        for (let followID of loggedUser.following) {
            // if logged user is following that user
            followID = typeof followID === 'string' ? parseInt(followID) : followID;
            if (userID === followID) {
                return true;
            }
        }

        return false;
    };

    me.addFollow = function () {
        return followRouter.addFollow({
            follower_id: loggedUser.id,
            leader_id: userID
        });
    };

    me.removeFollow = function () {
        return followRouter.removeFollow({
            follower_id: loggedUser.id,
            leader_id: userID
        });
    };

    return me;
};

export {followUtils as default};