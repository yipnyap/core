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

    yipnyap_constants.setDipswitch = function (key: string, value: any) {
        if (yipnyap_constants.currentUser) {
            const dipswitch = yipnyap_constants.currentUser?.dipswitches?.find((dipswitch: { id: any; }) => dipswitch.id === this.id);
            if (dipswitch) {
                dipswitch[key] = value;
            }

            fetch('/api/v2/dipswitch/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
                },
                body: JSON.stringify({
                    key,
                    value,
                }),
            }).then((response) => {
                return response.status === 200;
            }).catch((error) => {
                console.error(error);
                return false;
            });

            return true;
        } else {
            return false;
        }
    }
}

