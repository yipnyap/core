/**
 * Get a member by their ID or username
 * via /api/v2/members/:id
 *
 * @param {string} id The ID or username of the member
 * @param {number} bits The bitwise flags for what to include
 */
export default async function getMember(id: string, bits: number = 0) {
    const res = await fetch(`/api/v2/member/${id}/${bits || ''}`);
    const json = await res.json();
    return json;
}

/**
 * Get the current member
 */
export async function getCurrentMember() {
    const res = await fetch(`/api/v2/member/@me`, {
        headers: {
            'X-WP-Nonce': yipnyap_constants.wp_rest_nonce
        }
    });
    return await res.json();
}
