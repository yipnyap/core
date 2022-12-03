/**
 * Global variable init
 */
// Populate the current user to the global "yipnyap_constants" object
import {populateCurrentUser} from './global/user';
populateCurrentUser();

/**
 * Profile DOM
 */
import './profile/header';
