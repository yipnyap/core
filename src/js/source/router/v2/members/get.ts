/**
 * Get a member by their ID or username
 * via /api/v2/members/:id
 *
 * @param {string} id The ID or username of the member
 */
export default async function getMember(id: string) {
    const res = await fetch(`/api/v2/members/${id}`);
    const json = await res.json();
    return json;
}
