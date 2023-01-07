/**
 * Global variable init
 */
// Populate the current user to the global "yipnyap_constants" object
import {populateCurrentUser} from './global/user';
populateCurrentUser().then(async r => {
    /**
     * Activity DOM
     */
    await import('./activity');

    /**
     * Profile DOM
     */
    await import('./profile/header');
    // pages
    await import('./profile/pages/settings');
});
