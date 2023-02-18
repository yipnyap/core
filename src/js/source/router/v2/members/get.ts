/**
 * Get a member by their ID or username
 * via /api/v2/members/:id(/:bits)
 *
 * @param {string} id The ID or username of the member
 * @param {number} bits The bitwise flags for what to include
 */
export default async function getMember(id: string, bits: number = 0) {
    const res = await fetch(`/api/v2/member/${id}/${bits || ''}`);
    return await res.json();
}

/**
 * Get the current member
 */
export async function getCurrentMember() {
    const res = await fetch(`/api/v2/member/@me/8`, {
        headers: {
            'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
        }
    });
    return await res.json();
}

/**
 * Get member groups
 */
export async function getMemberGroups(id: string) {
    // Check yipnyap_constants.currentUser for groups, if not, populate it.
    if (!Array.isArray(yipnyap_constants.currentUser.groups)) {
        const res = await fetch(`/api/v2/member/${id}/groups`);
        const json = await res.json();

        if (Array.isArray(json)) {
            console.log(`[🗄️ Cache] Member groups for ${id} cached.`);
            yipnyap_constants.currentUser.groups = json;
        } else {
            console.log(`[🗄️ Cache] Member groups is non-existent or not an array for ${id}`);
            yipnyap_constants.currentUser.groups = [];
        }
    } else {
        console.log(`[🗄️ Cache] Member groups for ${id} already cached.`);
    }

    return yipnyap_constants.currentUser.groups;
}

/**
 * Get member friends
 */
export async function getMemberFriends(id: string) {
    // Check yipnyap_constants.currentUser for friends, if not, populate it.
    if (!Array.isArray(yipnyap_constants.currentUser.friends)) {
        const res = await fetch(`/api/v2/member/${id}/friends`);
        const json = await res.json();

        if (Array.isArray(json)) {
            yipnyap_constants.currentUser.friends = json;
        } else {
            yipnyap_constants.currentUser.friends = [];
        }
    } else {
        console.log(`[🗄️ Cache] Member friends for ${id} already cached.`);
    }

    return yipnyap_constants.currentUser.friends;
}
