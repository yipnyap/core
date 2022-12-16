/**
 * POST check if user is following a user
 *
 * @returns boolean
 * @param userid
 */
export async function isFollowing(userid: number): Promise<boolean> {
    const res = await fetch(`/api/v2/relationships/following`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
        },
        body: JSON.stringify({
            'target': userid
        })
    });
    const data = await res.json();
    return data.relationship;
}

/**
 * POST follow a user
 *
 * @returns boolean
 * @param userid
 */
export async function follow(userid: number): Promise<{ success: boolean; relationship: any }> {
    const res = await fetch(`/api/v2/relationships/follow`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
        },
        body: JSON.stringify({
            'target': userid
        })
    });
    return await res.json();
}

/**
 * POST unfollow a user
 *
 * @returns boolean
 * @param userid
 */
export async function unfollow(userid: number): Promise<{ success: boolean; relationship: any }> {
    const res = await fetch(`/api/v2/relationships/unfollow`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
        },
        body: JSON.stringify({
            'target': userid
        })
    });
    return await res.json();
}

/**
 * POST friend request a user
 *
 * @returns boolean
 * @param userid
 */
export async function friendRequest(userid: number): Promise<{ success: boolean; relationship: any }> {
    const res = await fetch(`/api/v2/relationships/friend/request`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
        },
        body: JSON.stringify({
            'target': userid
        })
    });
    return await res.json();
}

/**
 * GET relationship
 */
export async function getRelationship(userid: number): Promise<{ success: boolean; relationship: any }> {
    const res = await fetch(`/api/v2/relationships/get/${userid}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
        }
    });
    return await res.json();
}

/**
 * GET friend requests for logged in user
 */
export async function getFriendRequests(): Promise<{ success: boolean; requests: any[] }> {
    const res = await fetch(`/api/v2/relationships/friend/request`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
        }
    });
    return await res.json();
}