import {getCurrentMember} from "../../../router/v2/members/get";

/**
 * Fetch the current logged-in user, and attach it to the global "yipnyap_constants" object
 */
export async function populateCurrentUser() {
    const user = await getCurrentMember();
    if (user) {
        yipnyap_constants.currentUser = user;
    }
}

