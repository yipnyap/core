const ConsoleLogBackup = console.log;

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

/*--------------------------------------------------------------------
                        COMPONENT DOM
--------------------------------------------------------------------*/
/*-----------------------
    SEARCH FORM
-----------------------*/
import './component-dom/search/search-form';

/*---------------------------
    HEADER
---------------------------*/
import './component-dom/header/header';
import './component-dom/header/header-notifications';

/*---------------------------
    ONBOARDING
---------------------------*/
import './component-dom/onboarding/landing-activity-header';

/*---------------------------
    COMMENT LIST
---------------------------*/
import './component-dom/comments/comment-list';

/*---------------------------
    POST PREVIEW LIST
---------------------------*/
import './component-dom/posts/post-preview-list';

/*---------------------------
    MEMBER LIST
---------------------------*/
import './component-dom/members/members-list';

/*---------------------------
    GROUP LIST
---------------------------*/
import './component-dom/groups/groups-list';
import './component-dom/groups/group-members-list';

/*---------------------------
    MEMBER HEADER ACTIONS
---------------------------*/
import './component-dom/members/profile-header-actions';

/*---------------------------
    GROUP HEADER ACTIONS
---------------------------*/
import './component-dom/groups/group-header-actions';

/*---------------------------
    ACTIVITY LIST
---------------------------*/
import './component-dom/activity/list-activities';
// import './component-dom/activity/activity-notice';

/*---------------------------
    MEDIA LIST
---------------------------*/
import './component-dom/media/photo-list';
import './component-dom/media/video-list';

/*---------------------------
    WIDGETS
---------------------------*/
import './component-dom/widget/widget-photos';

/*-----------------------
    ACCOUNT HUB
-----------------------*/
import './component-dom/settings/settings-profile';
import './component-dom/settings/settings-social';
import './component-dom/settings/settings-stream';
import './component-dom/settings/settings-notifications';
import './component-dom/settings/settings-messages';
import './component-dom/settings/settings-friend-requests';

import './component-dom/settings/settings-account-info';
import './component-dom/settings/settings-password';
import './component-dom/settings/settings-email-settings';

import './component-dom/settings/settings-manage-groups';
import './component-dom/settings/settings-send-group-invitations';
import './component-dom/settings/settings-received-group-invitations';
import './component-dom/settings/settings-group-membership-requests';

/*-----------------
    PAGE LOADER
-----------------*/
import './global/page-loader';
