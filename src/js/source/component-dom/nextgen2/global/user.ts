import {getCurrentMember} from "../../../router/v2/members/get";

/**
 * Fetch the current logged-in user, and attach it to the global "yipnyap_constants" object
 */
export async function populateCurrentUser() {
    const user = await getCurrentMember();
    if (user.code !== 404) {
        yipnyap_constants.currentUser = user;
    } else {
        yipnyap_constants.currentUser = null;
    }
}

