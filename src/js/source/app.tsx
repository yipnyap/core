const ConsoleLogBackup = console.log;

// @ts-ignore
ConsoleLogBackup(`%cYipnyap ${yipnyap_constants.yipnyap_server_version}`, 'color: #00ff00;');

if (localStorage.getItem('debug') !== 'true') {
    console.log = () => {};
} else {
    console.log('Howdy!');
}

/*-------------
    SIDEBAR
-------------*/
import './sidebar/sidebar';

/*------------
    SVG
------------*/
import './utils/svg-loader';
import './utils/svg-loader.cmui';

/*----------------
    SCROLLBARS
----------------*/
import 'simplebar';

/*------------
    FORM
------------*/
import './form/form-input';

/*--------------
    GLOBAL
--------------*/
import './global/smooth-scroll';
import './global/sliders';
import './global/progressBars';
import './global/hexagons';
import './global/avatar-progressbar';
import './global/popups';
import './global/dropdowns';
import './global/tab';
import './global/tooltips';
import './global/accordions';
import './global/forum';
import './global/user-delete';
import './global/vk-el-menu-mobile';
import './global/search-mobile';

/**
 * Compoent DOM Hooks
 */
import './component-dom/nextgen2';

/*--------------------------------------------------------------------
                        COMPONENT DOM LEGACY
--------------------------------------------------------------------*/
/*-----------------------
    SEARCH FORM
-----------------------*/
import './component-dom/legacy/search/search-form';

/*---------------------------
    HEADER
---------------------------*/
import './component-dom/legacy/header/header';
import './component-dom/legacy/header/header-notifications';

/*---------------------------
    ONBOARDING
---------------------------*/
import './component-dom/legacy/onboarding/landing-activity-header';

/*---------------------------
    COMMENT LIST
---------------------------*/
import './component-dom/legacy/comments/comment-list';

/*---------------------------
    POST PREVIEW LIST
---------------------------*/
import './component-dom/legacy/posts/post-preview-list';

/*---------------------------
    MEMBER LIST
---------------------------*/
import './component-dom/legacy/members/members-list';

/*---------------------------
    GROUP LIST
---------------------------*/
import './component-dom/legacy/groups/groups-list';
import './component-dom/legacy/groups/group-members-list';

/*---------------------------
    MEMBER HEADER ACTIONS
---------------------------*/
import './component-dom/legacy/members/profile-header-actions';

/*---------------------------
    GROUP HEADER ACTIONS
---------------------------*/
import './component-dom/legacy/groups/group-header-actions';

/*---------------------------
    ACTIVITY LIST
---------------------------*/
import './component-dom/legacy/activity/list-activities';
// import './component-dom/legacy/activity/activity-notice';

/*---------------------------
    MEDIA LIST
---------------------------*/
import './component-dom/legacy/media/photo-list';
import './component-dom/legacy/media/video-list';

/*---------------------------
    WIDGETS
---------------------------*/
import './component-dom/legacy/widget/widget-photos';

/*-----------------------
    ACCOUNT HUB
-----------------------*/
import './component-dom/legacy/settings/settings-profile';
import './component-dom/legacy/settings/settings-social';
import './component-dom/legacy/settings/settings-stream';
import './component-dom/legacy/settings/settings-notifications';
import './component-dom/legacy/settings/settings-messages';
import './component-dom/legacy/settings/settings-friend-requests';

import './component-dom/legacy/settings/settings-account-info';
import './component-dom/legacy/settings/settings-password';
import './component-dom/legacy/settings/settings-email-settings';

import './component-dom/legacy/settings/settings-manage-groups';
import './component-dom/legacy/settings/settings-send-group-invitations';
import './component-dom/legacy/settings/settings-received-group-invitations';
import './component-dom/legacy/settings/settings-group-membership-requests';

/*-----------------
    PAGE LOADER
-----------------*/
import './global/page-loader';
