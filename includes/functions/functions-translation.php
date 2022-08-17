<?php
/**
 * Yipnyap TRANSLATION functions
 * 
 * @since 1.0.0
 */

 /**
  * Returns all translation strings needed for dynamic scripts
  */
function yipnyap_translation_get() {
  return [
    /**
     * Backend - Theme Activation
     */
    'activate'                                => esc_html__('Activate!', 'yipnyap'),
    'activating'                              => esc_html__('Activating...', 'yipnyap'),
    'activation_form_wrong_pc_or_token_error' => esc_html__('Wrong Purchase Code or Access Token.', 'yipnyap'),

    /**
     * Backend - Plugin Installer
     */
    'required_plugins_install_button_text'    => esc_html__('Install / Update / Activate Plugins', 'yipnyap'),
    'processing'                              => esc_html__('Processing...', 'yipnyap'),

    /**
     * Global
     */
    'day'   => esc_html__('Day', 'yipnyap'),
    'month' => esc_html__('Month', 'yipnyap'),
    'year'  => esc_html__('Year', 'yipnyap'),

    /**
     * Header Search
     */
    'search_placeholder'              => esc_html__('Enter your search here...', 'yipnyap'),
    'members'                         => esc_html__('Members', 'yipnyap'),
    'no_members_found'                => esc_html__('No members found', 'yipnyap'),
    'groups'                          => esc_html__('Groups', 'yipnyap'),
    'no_groups_found'                 => esc_html__('No groups found', 'yipnyap'),
    'posts'                           => esc_html__('Posts', 'yipnyap'),
    'by'                              => esc_html_x('By', 'by author_name', 'yipnyap'),

    /**
     * Header Friend Requests
     */
    'friend_requests'             => esc_html__('Friend Requests', 'yipnyap'),
    'received'                    => esc_html__('Received', 'yipnyap'),
    'sent'                        => esc_html__('Sent', 'yipnyap'),
    'no_friend_requests_received' => esc_html__('No friend requests received', 'yipnyap'),
    'no_friend_requests_sent'     => esc_html__('No friend requests sent', 'yipnyap'),
    'view_all_friend_requests'    => esc_html__('View all Friend Requests', 'yipnyap'),

    /**
     * Header Messages
     */
    'messages'                    => esc_html__('Messages', 'yipnyap'),
    'no_messages_received'        => esc_html__('No messages received', 'yipnyap'),
    'view_all_messages'           => esc_html__('View all Messages', 'yipnyap'),

    /**
     * Header Notifications
     */
    'email_settings'              => esc_html__('Email Settings', 'yipnyap'),
    'notifications'               => esc_html__('Notifications', 'yipnyap'),
    'no_notifications_received'   => esc_html__('No notifications received', 'yipnyap'),
    'view_all_notifications'      => esc_html__('View all Notifications', 'yipnyap'),

    /**
     * Filterable List
     */
    'no_results_found'            => esc_html__('No results found', 'yipnyap'),
    'item_list_no_results_text'   => esc_html__('Please try with another filter!', 'yipnyap'),

    'showing_results_text_1'      => esc_html_x('Showing', '"showing" n results out of m total', 'yipnyap'),
    'showing_results_text_2'      => esc_html_x('out of', 'showing n results "out of" m total', 'yipnyap'),

    /**
     * Post Filters
     */
    'category'                    => esc_html__('Category', 'yipnyap'),
    'all_categories'              => esc_html__('All Categories', 'yipnyap'),
    'type'                        => esc_html__('Type', 'yipnyap'),
    'all'                         => esc_html__('All', 'yipnyap'),
    'filter_by'                   => esc_html_x('Filter By', 'narrow a search by some criteria', 'yipnyap'),
    'date'                        => esc_html_x('Date', 'e.g. (10/08/2020)', 'yipnyap'),
    'popularity'                  => esc_html__('Popularity', 'yipnyap'),
    'order_by'                    => esc_html__('Order By', 'yipnyap'),
    'ascending'                   => esc_html__('Ascending', 'yipnyap'),
    'descending'                  => esc_html__('Descending', 'yipnyap'),
    'filter_action'               => esc_html_x('Filter', 'to narrow a search', 'yipnyap'),
    'result'                      => esc_html__('Result', 'yipnyap'),
    'results'                     => esc_html__('Results', 'yipnyap'),

    /**
     * Grid Filters
     */
    'grid_filter'                 => [
      'big'   => esc_html_x('Big Grid', 'how the content is displayed on screen', 'yipnyap'),
      'small' => esc_html_x('Small Grid', 'how the content is displayed on screen', 'yipnyap'),
      'list'  => esc_html_x('List Grid', 'how the content is displayed on screen', 'yipnyap')
    ],

    /**
     * Post Preview
     */
    'read_more'                   => esc_html__('Read More...', 'yipnyap'),
    'comment'                     => esc_html_x('Comment', 'a comment', 'yipnyap'),
    'comments'                    => esc_html__('Comments', 'yipnyap'),
    'share'                       => esc_html_x('Share', 'a share', 'yipnyap'),
    'shares'                      => esc_html_x('Shares', '0 / 2 or more replies', 'yipnyap'),

    /**
     * Reaction Filters
     */
    'all'                         => esc_html_x('All', 'show everything', 'yipnyap'),
    'more_reactions_text_1'       => esc_html_x('and', '"and" n more reactions', 'yipnyap'),
    'more_reactions_text_2'       => esc_html_x('more...', 'and n "more" reactions', 'yipnyap'),

    /**
     * Widget Tabs
     */
    'newest'                      => esc_html__('Newest', 'yipnyap'),
    'popular'                     => esc_html__('Popular', 'yipnyap'),
    'active'                      => esc_html_x('Active', 'user activity', 'yipnyap'),

    /**
     * Photos Widget
     */
    'no_photos_found'             => esc_html__('No photos found', 'yipnyap'),

    /**
     * Friends Widget
     */
    'friends'                     => esc_html__('Friends', 'yipnyap'),
    'no_friends_found'            => esc_html__('No friends found', 'yipnyap'),
    'find_friends'                => esc_html__('Find Friends', 'yipnyap'),
    'see_all_friends'             => esc_html__('See all Friends', 'yipnyap'),

    /**
     * Achievement Pages
     */
    'locked'                      => esc_html__('Locked', 'yipnyap'),
    'unlocked!'                   => esc_html__('Unlocked!', 'yipnyap'),

    /**
     * Activity Form
     */
    'status_update'                 => esc_html__('Status Update', 'yipnyap'),
    'post_in'                       => esc_html__('Post In', 'yipnyap'),
    'my_profile'                    => esc_html__('My Profile', 'yipnyap'),
    'privacy'                       => esc_html__('Privacy', 'yipnyap'),
    'public'                        => esc_html__('Public', 'yipnyap'),
    'private'                       => esc_html__('Private', 'yipnyap'),
    'activity_form_placeholder_1'   => esc_html_x('Hey,', '(Activity Form) Placeholder text before user name', 'yipnyap'),
    'activity_form_placeholder_2'   => esc_html_x('Write your stuff, or @annoy some people', '(Activity Form) Placeholder text after user name', 'yipnyap'),
    'add_photo'                     => esc_html__('Add Photo', 'yipnyap'),
    'add_video'                     => esc_html__('Add Video', 'yipnyap'),
    'upload_photo'                  => esc_html__('Upload Photo', 'yipnyap'),
    'discard'                       => esc_html__('Discard', 'yipnyap'),
    'save'                          => esc_html__('Save', 'yipnyap'),
    'post_action'                   => esc_html_x('Post', 'to post something', 'yipnyap'),
    'activity_form_empty_error'     => esc_html__('Please enter some text or add a photo or video!', 'yipnyap'),
    'upload_form_photo_empty_error' => esc_html__('Please add a photo to upload!', 'yipnyap'),
    'upload_form_video_empty_error' => esc_html__('Please add a video to upload!', 'yipnyap'),
    'maximum_size_accepted_is'      => esc_html__('Maximum size accepted is', 'yipnyap'),
    'size_is_too_big'               => esc_html__('size is too big!', 'yipnyap'),
    'file_extension_is_not_allowed' => esc_html__('file extension is not allowed!', 'yipnyap'),

    /**
     * Activity Filters
     */
    'all_updates'                 => esc_html_x('All Updates', 'to show all post updates', 'yipnyap'),
    'following'                   => esc_html__('Following', 'yipnyap'),
    'mentions'                    => esc_html__('Mentions', 'yipnyap'),
    'favorites'                   => esc_html__('Favorites', 'yipnyap'),
    'scope'                       => esc_html__('Scope', 'yipnyap'),
    'show'                        => esc_html__('Show', 'yipnyap'),
    'everything'                  => esc_html__('Everything', 'yipnyap'),
    'status'                      => esc_html__('Status', 'yipnyap'),
    'shares'                      => esc_html__('Shares', 'yipnyap'),
    'media'                       => esc_html__('Media', 'yipnyap'),
    'photos'                      => esc_html__('Photos', 'yipnyap'),
    'videos'                      => esc_html__('Videos', 'yipnyap'),
    'friendships'                 => esc_html__('Friendships', 'yipnyap'),
    'new_groups'                  => esc_html__('New Groups', 'yipnyap'),

    /**
     * Activity Settings
     */
    'add_favorite'                  => esc_html__('Add Favorite', 'yipnyap'),
    'remove_favorite'               => esc_html__('Remove Favorite', 'yipnyap'),
    'pin_to_top'                    => esc_html__('Pin to Top', 'yipnyap'),
    'unpin_from_top'                => esc_html__('Unpin from Top', 'yipnyap'),
    'edit_post'                     => esc_html__('Edit Post', 'yipnyap'),
    'delete_post'                   => esc_html__('Delete Post', 'yipnyap'),
    'delete_activity_message_title' => esc_html__('Delete Post', 'yipnyap'),
    'delete_activity_message_text'  => esc_html__('Are you sure you want to delete this post?', 'yipnyap'),
    'edit_comment'                  => esc_html__('Edit Comment', 'yipnyap'),
    'cancel_edit'                   => esc_html__('Cancel Edit', 'yipnyap'),
    'delete_comment'                => esc_html__('Delete Comment', 'yipnyap'),
    'delete_comment_message_title'  => esc_html__('Delete Comment', 'yipnyap'),
    'delete_comment_message_text'   => esc_html__('Are you sure you want to delete this comment?', 'yipnyap'),

    /**
     * Activity
     */
    'edited_by'                       => esc_html__('&bull; edited by', 'yipnyap'),
    'and'                             => esc_html__('and', 'yipnyap'),
    'in_the_group'                    => esc_html__('in the group', 'yipnyap'),
    'shared_content_deleted_title'    => esc_html__('Oops! -', 'yipnyap'),
    'shared_content_deleted_text'     => esc_html__('the shared content was deleted.', 'yipnyap'),
    'show_more'                       => esc_html__('Show More', 'yipnyap'),


    /**
     * Content Actions
     */
    'comment'                     => esc_html_x('Comment', 'a comment', 'yipnyap'),
    'comments'                    => esc_html__('Comments', 'yipnyap'),
    'share'                       => esc_html_x('Share', 'a share', 'yipnyap'),
    'shares'                      => esc_html_x('Shares', '0 / 2 or more shares', 'yipnyap'),


    /**
     * Post Footer
     */
    'react'                       => esc_html_x('React!', 'to react to something', 'yipnyap'),
    'comment_action'              => esc_html_x('Comment', 'to comment on something', 'yipnyap'),
    'share_action'                => esc_html_x('Share', 'to share something', 'yipnyap'),

    /**
     * Comment Form
     */
    'leave_a_comment'               => esc_html__('Leave a Comment', 'yipnyap'),
    'your_reply'                    => esc_html__('Your Reply', 'yipnyap'),
    'discard'                       => esc_html__('Discard', 'yipnyap'),
    'post_reply'                    => esc_html__('Post Reply', 'yipnyap'),
    'reply_action'                  => esc_html_x('Reply', 'to reply to something', 'yipnyap'),
    'cancel_action'                 => esc_html_x('Cancel', 'to cancel something', 'yipnyap'),
    'load'                          => esc_html__('Load', 'yipnyap'),
    'reply'                         => esc_html_x('Reply', 'a reply' ,'yipnyap'),
    'replies'                       => esc_html_x('Replies', '0 / 2 or more replies' ,'yipnyap'),
    'load_more_comments'            => esc_html__('Load More Comments', 'yipnyap'),
    'comment_empty_message'         => esc_html__('Please enter a comment', 'yipnyap'),
    'comment_not_approved_message'  => esc_html__('Your comment is awaiting moderation and will be visible when approved', 'yipnyap'),

    /**
     * Group Filters
     */
    'search_groups'               => esc_html__('Search Groups', 'yipnyap'),
    'order_by'                    => esc_html__('Order By', 'yipnyap'),
    'alphabetical'                => esc_html__('Alphabetical', 'yipnyap'),
    'newest_groups'               => esc_html__('Newest Groups', 'yipnyap'),
    'recently_active'             => esc_html__('Recently Active', 'yipnyap'),

    /**
     * Group Preview
     */
    'group'                       => esc_html__('Group', 'yipnyap'),
    'member'                      => esc_html__('Member', 'yipnyap'),
    'post'                        => esc_html_x('Post', 'a post', 'yipnyap'),
    'banned'                      => esc_html_x('Banned', 'banned from something', 'yipnyap'),

    /**
     * Message Box
     */
    'accept'                      => esc_html__('Accept', 'yipnyap'),
    'cancel'                      => esc_html__('Cancel', 'yipnyap'),
    'continue'                    => esc_html__('Continue', 'yipnyap'),

    /**
     * Group Actions
     */
    'join_group'                  => esc_html__('Join Group', 'yipnyap'),
    'leave_group'                 => esc_html__('Leave Group', 'yipnyap'),
    'send_join_request'           => esc_html__('Send Join Request', 'yipnyap'),
    'cancel_join_request'         => esc_html__('Cancel Join Request', 'yipnyap'),
    'reject_join_request'         => esc_html__('Reject Join Request', 'yipnyap'),
    'accept_join_request'         => esc_html__('Accept Join Request', 'yipnyap'),
    'remove_member'               => esc_html__('Remove Member', 'yipnyap'),
    'remove_invitation'           => esc_html__('Remove Invitation', 'yipnyap'),
    'reject_invitation'           => esc_html__('Reject Invitation', 'yipnyap'),
    'accept_invitation'           => esc_html__('Accept Invitation', 'yipnyap'),
    'ban_member'                  => esc_html__('Ban Member', 'yipnyap'),
    'unban_member'                => esc_html__('Unban Member', 'yipnyap'),
    'promote_to_admin'            => esc_html__('Promote to Admin', 'yipnyap'),
    'promote_to_mod'              => esc_html__('Promote to Mod', 'yipnyap'),
    'demote_to_mod'               => esc_html__('Demote to Mod', 'yipnyap'),
    'demote_to_member'            => esc_html__('Demote to Member', 'yipnyap'),
    'manage_groups'               => esc_html__('Manage Groups', 'yipnyap'),

    /**
     * Member Filters
     */
    'search_members'              => esc_html__('Search Members', 'yipnyap'),
    'order_by'                    => esc_html__('Order By', 'yipnyap'),
    'alphabetical'                => esc_html__('Alphabetical', 'yipnyap'),
    'newest_members'              => esc_html__('Newest Members', 'yipnyap'),
    'recently_active'             => esc_html__('Recently Active', 'yipnyap'),

    /**
     * Member Preview
     */
    'post'                        => esc_html_x('Post', 'a post', 'yipnyap'),
    'friend'                      => esc_html__('Friend', 'yipnyap'),
    'no_social_networks_linked'   => esc_html__('No social networks linked', 'yipnyap'),
    'no_badges_unlocked'          => esc_html__('No badges unlocked', 'yipnyap'),

    /**
     * Member Actions
     */
    'add_friend'                  => esc_html__('Add Friend', 'yipnyap'),
    'remove_friend'               => esc_html__('Remove Friend', 'yipnyap'),
    'accept_friend'               => esc_html__('Accept Friend Request', 'yipnyap'),
    'reject_friend'               => esc_html__('Reject Friend Request', 'yipnyap'),
    'withdraw_friend'             => esc_html__('Cancel Friend Request', 'yipnyap'),
    'follow'                      => esc_html__('Follow', 'yipnyap'),
    'unfollow'                    => esc_html__('Unfollow', 'yipnyap'),
    'send_message'                => esc_html__('Send Message', 'yipnyap'),

    /**
     * Activity Media List
     */
    'browse'                        => esc_html__('Browse', 'yipnyap'),
    'photos'                        => esc_html__('Photos', 'yipnyap'),
    'photos_no_results_title'       => esc_html__('No photos found', 'yipnyap'),
    'photos_no_results_text'        => esc_html__('There aren\'t any uploaded photos!', 'yipnyap'),
    'videos_no_results_title'       => esc_html__('No videos found', 'yipnyap'),
    'videos_no_results_text'        => esc_html__('There aren\'t any uploaded videos!', 'yipnyap'),
    'upload_photos'                 => esc_html__('Upload Photos', 'yipnyap'),
    'upload_video'                  => esc_html__('Upload Video', 'yipnyap'),
    'select_all'                    => esc_html__('Select All', 'yipnyap'),
    'unselect_all'                  => esc_html__('Unselect All', 'yipnyap'),
    'delete'                        => esc_html__('Delete', 'yipnyap'),

    /**
     * Settings
     */
    'my_profile'                  => esc_html__('My Profile', 'yipnyap'),
    'save_changes'                => esc_html__('Save Changes', 'yipnyap'),
    'saving'                      => esc_html__('Saving...', 'yipnyap'),

    /**
     * Profile Info Settings
     */
    'profile_info'                => esc_html__('Profile Info', 'yipnyap'),
    'change_avatar'               => esc_html__('Change Avatar', 'yipnyap'),
    'change_cover'                => esc_html__('Change Cover', 'yipnyap'),
    'upload_error'                => esc_html__('Upload Error', 'yipnyap'),
    'upload_error_message'        => esc_html__('An error has ocurred, please verify avatar/cover dimensions or try again later', 'yipnyap'),
    'avatar_upload_error'         => esc_html__('Avatar Upload Error', 'yipnyap'),
    'cover_upload_error'          => esc_html__('Cover Upload Error', 'yipnyap'),
    'select_an_option'            => esc_html__('Select an Option', 'yipnyap'),

    /**
     * Social Settings
     */
    'social_networks'             => esc_html__('Social Networks', 'yipnyap'),
    'no_social_info_available'    => esc_html__('No social info available', 'yipnyap'),

    /**
     * Notification Settings
     */
    'notifications_received_no_results_title' => esc_html__('No notifications received', 'yipnyap'),
    'notifications_received_no_results_text'  => esc_html__('If you receive notifications they will appear here!', 'yipnyap'),
    'mark_as_read'                            => esc_html__('Mark as Read', 'yipnyap'),
    'accept'                                  => esc_html__('Accept', 'yipnyap'),
    'cancel'                                  => esc_html__('Cancel', 'yipnyap'),
    'delete_selected_message'                 => esc_html__('Are you sure you want to delete all selected items?', 'yipnyap'),

    /**
     * Stream Settings
     */
    'stream'                                => esc_html__('Stream', 'yipnyap'),
    'stream_settings_username_title'        => esc_html__('Twitch Streamer - Username', 'yipnyap'),
    'stream_settings_username_placeholder'  => esc_html__('Enter Twitch streamer username here...', 'yipnyap'),
    'stream_settings_preview_title'         => esc_html__('Twitch Stream - Preview', 'yipnyap'),
    'stream_settings_preview_text'          => esc_html__('Below, you can see a preview of how the Twitch stream will look like with the currently entered streamer username', 'yipnyap'),
    'stream_settings_preview_no_results'    => esc_html__('No streamer username entered', 'yipnyap'),

    /**
     * Message Settings
     */
    'inbox'                       => esc_html__('Inbox', 'yipnyap'),
    'sentbox'                     => esc_html__('Sentbox', 'yipnyap'),
    'starred'                     => esc_html_x('Starred', 'favorites', 'yipnyap'),
    'new_message'                 => esc_html__('New Message', 'yipnyap'),
    'started'                     => esc_html__('Started', 'yipnyap'),
    'add_friend_placeholder'      => esc_html__('Use &#64; to add a friend...', 'yipnyap'),
    'search_messages'             => esc_html__('Search Messages', 'yipnyap'),
    'write_a_message'             => esc_html__('Write a Message...', 'yipnyap'),
    'no_messages_found'           => esc_html__('No messages found', 'yipnyap'),
    'message_search_no_results'   => esc_html__('No messages match your search', 'yipnyap'),
    'star_action'                 => esc_html_x('Star', 'favorite something', 'yipnyap'),
    'unstar'                      => esc_html_x('Unstar', 'unfavorite something', 'yipnyap'),
    'delete_item_message'         => esc_html__('Are you sure you want to delete this?', 'yipnyap'),
    'you'                         => esc_html__('You', 'yipnyap'),

    /**
     * Friend Requests Settings
     */
    'friend_requests_received'                  => esc_html__('Friend Requests Received', 'yipnyap'),
    'friend_requests_received_no_results_title' => esc_html__('No friend requests received', 'yipnyap'),
    'friend_requests_received_no_results_text'  => esc_html__('If you receive friend requests they will appear here!', 'yipnyap'),
    'friend_requests_sent'                      => esc_html__('Friend Requests Sent', 'yipnyap'),
    'friend_requests_sent_no_results_title'     => esc_html__('No friend requests sent', 'yipnyap'),
    'friend_requests_sent_no_results_text'      => esc_html__('If you send friend requests they will appear here!', 'yipnyap'),

    /**
     * Account Info Settings
     */
    'account'                               => esc_html__('Account', 'yipnyap'),
    'account_info'                          => esc_html__('Account Info', 'yipnyap'),
    'no_account_info_available'             => esc_html__('No account info available', 'yipnyap'),

    /**
     * Change Password Settings
     */
    'change_password'                       => esc_html__('Change Password', 'yipnyap'),
    'enter_your_current_password'           => esc_html__('Enter your Current Password', 'yipnyap'),
    'your_new_password'                     => esc_html__('Your New Password', 'yipnyap'),
    'confirm_new_password'                  => esc_html__('Confirm New Password', 'yipnyap'),
    'error'                                 => esc_html__('Error', 'yipnyap'),
    'change_password_error_title'           => esc_html__('Change Password Error', 'yipnyap'),
    'change_password_error_text'            => esc_html__('Couldn\'t change password. Please try again later', 'yipnyap'),
    'current_password_mismatch_error_title' => esc_html__('Incorrect Password', 'yipnyap'),
    'current_password_mismatch_error_text'  => esc_html__('Entered current password doesn\'t match your password. Please make sure to enter your current password correctly', 'yipnyap'),
    'new_password_mismatch_error_title'     => esc_html__('New Password Mismatch', 'yipnyap'),
    'new_password_mismatch_error_text'      => esc_html__('New password field and new password confirmation field don\'t match. Please make sure to enter the same password in both fields', 'yipnyap'),

    /**
     * Email Settings
     */
    'activity'                              => esc_html__('Activity', 'yipnyap'),

    'mentions'                              => esc_html__('Mentions', 'yipnyap'),
    'email_settings_mentions_description'   => esc_html__('A member mentions you in an update', 'yipnyap'),

    'replies'                               => esc_html__('Replies', 'yipnyap'),
    'email_settings_replies_description'    => esc_html__('A member replies to an update or comment you\'ve posted', 'yipnyap'),

    'new_message'                           => esc_html__('New Message', 'yipnyap'),
    'email_settings_newmessage_description' => esc_html__('A member sends you a new message', 'yipnyap'),

    'friends'                                           => esc_html__('Friends', 'yipnyap'),

    'new_friend_request'                                => esc_html__('New Friend Request', 'yipnyap'),
    'email_settings_newfriendrequest_description'       => esc_html__('A member sends you a friendship request', 'yipnyap'),

    'friend_request_accepted'                           => esc_html__('Friend Request Accepted', 'yipnyap'),
    'email_settings_friendrequestaccepted_description'  => esc_html__('A member accepts your friendship request', 'yipnyap'),

    'group_invite'                                              => esc_html__('Group Invite', 'yipnyap'),
    'email_settings_groupinvite_description'                    => esc_html__('A member invites you to join a group', 'yipnyap'),

    'group_update'                                              => esc_html__('Group Update', 'yipnyap'),
    'email_settings_groupupdate_description'                    => esc_html__('Group information is updated', 'yipnyap'),

    'group_promotion'                                           => esc_html__('Group Promotion', 'yipnyap'),
    'email_settings_grouppromotion_description'                 => esc_html__('You are promoted to a group administrator or moderator', 'yipnyap'),

    'private_group_membership_request'                          => esc_html__('Private Group Membership Request', 'yipnyap'),
    'email_settings_privategroupmembershiprequest_description'  => esc_html__('A member requests to join a private group for which you are an admin', 'yipnyap'),

    'group_join_request_status'                                 => esc_html__('Group Join Request Status', 'yipnyap'),
    'email_settings_groupjoinrequeststatus_description'         => esc_html__('Your request to join a group has been approved or denied', 'yipnyap'),

    /**
     * Manage Groups Settings
     */
    'manage_group'                          => esc_html__('Manage Group', 'yipnyap'),
    'manage_groups'                         => esc_html__('Manage Groups', 'yipnyap'),
    'cant_manage_groups_message'            => esc_html__('You can\'t manage any groups yet!', 'yipnyap'),
    'create_group'                          => esc_html__('Create Group!', 'yipnyap'),
    'create_new_group'                      => esc_html__('Create New Group', 'yipnyap'),
    'create_new_group_text'                 => esc_html__('Share your passion with others!', 'yipnyap'),
    'start_creating'                        => esc_html__('Start Creating!', 'yipnyap'),
    'creating'                              => esc_html__('Creating...', 'yipnyap'),
    'group_creator'                         => esc_html__('Group Creator', 'yipnyap'),
    'group_admin'                           => esc_html__('Group Admin', 'yipnyap'),
    'group_mod'                             => esc_html__('Group Mod', 'yipnyap'),

    'group_info'                            => esc_html__('Group Info', 'yipnyap'),
    'group_name'                            => esc_html__('Group Name', 'yipnyap'),
    'group_status'                          => esc_html__('Group Status', 'yipnyap'),
    'group_slug'                            => esc_html__('Group Slug (what you see on the URL)', 'yipnyap'),
    'group_description'                     => esc_html__('Group Description', 'yipnyap'),
    'forum'                                 => esc_html__('Forum', 'yipnyap'),
    'forums'                                => esc_html__('Forums', 'yipnyap'),
    'forum_topics'                          => esc_html__('Forum Topics', 'yipnyap'),
    'forum_replies'                         => esc_html__('Forum Replies', 'yipnyap'),
    'group_forum'                           => esc_html__('Group Forum', 'yipnyap'),
    'group_forum_enable_title'              => esc_html__('Should this group have a forum?', 'yipnyap'),
    'group_forum_enable_text'               => esc_html__('Enable forum for this group', 'yipnyap'),
    'forum_name'                            => esc_html__('Forum Name', 'yipnyap'),
    'forum_description'                     => esc_html__('Forum Description', 'yipnyap'),
    'forum_privacy'                         => esc_html__('Forum Privacy', 'yipnyap'),

    'avatar_and_cover'                      => esc_html__('Avatar and Cover', 'yipnyap'),

    'administrators'                        => esc_html__('Administrators', 'yipnyap'),
    'mods'                                  => esc_html__('Mods', 'yipnyap'),
    'banned_members'                        => esc_html__('Banned Members', 'yipnyap'),
    'no_mods_found'                         => esc_html__('No mods found', 'yipnyap'),
    'no_banned_members_found'               => esc_html__('No banned members found', 'yipnyap'),

    'delete_group'                          => esc_html__('Delete Group', 'yipnyap'),
    'delete_group_text'                     => esc_html__('Deleting a group will remove all its content, this action cannot be undone.', 'yipnyap'),
    'delete_group_confirmation'             => esc_html__('Are you sure you want to delete this group?', 'yipnyap'),

    'required_fields_message'               => esc_html__('Please fill all required fields', 'yipnyap'),
    'save_error_message'                    => esc_html__('Error when saving, please try again later', 'yipnyap'),
    'discard_all'                           => esc_html__('Discard All', 'yipnyap'),

    /**
     * Send Invitations Settings
     */
    'send_invitations'                      => esc_html__('Send Invitations', 'yipnyap'),
    'send_invitations_no_results_title'     => esc_html__('No groups', 'yipnyap'),
    'send_invitations_no_results_text_1'    => esc_html__('You don\'t belong to any groups. Create or join a group first!', 'yipnyap'),
    'send_invitations_no_results_text_2'    => esc_html__('You don\'t belong to any groups which you can send invitations from', 'yipnyap'),
    'select_the_group'                      => esc_html__('Select the Group', 'yipnyap'),
    'select_your_friends'                   => esc_html__('Select your Friends', 'yipnyap'),
    'send_invitations_friends_no_results'   => esc_html__('You don\'t have any friends that can be invited to this group', 'yipnyap'),
    'sending'                               => esc_html__('Sending...', 'yipnyap'),
    'pending_invitations'                   => esc_html__('Pending Invitations', 'yipnyap'),
    'pending_invitations_no_results_title'  => esc_html__('No invitations sent', 'yipnyap'),
    'pending_invitations_no_results_text'   => esc_html__('If you send invitations they will appear here!', 'yipnyap'),

    /**
     * Received Invitations Settings
     */
    'received_invitations'                          => esc_html__('Received Invitations', 'yipnyap'),
    'received_invitations_no_results_title'         => esc_html__('No invitations received', 'yipnyap'),
    'received_invitations_no_results_text'          => esc_html__('If you receive invitations they will appear here!', 'yipnyap'),
    'invited_by'                                    => esc_html__('Invited By', 'yipnyap'),
    'received_membership_requests'                  => esc_html__('Received Membership Requests', 'yipnyap'),
    'received_membership_requests_no_results_title' => esc_html__('No membership requests received', 'yipnyap'),
    'received_membership_requests_no_results_text'  => esc_html__('If you receive membership requests they will appear here!', 'yipnyap'),
    'sent_membership_requests'                      => esc_html__('Sent Membership Requests', 'yipnyap'),
    'sent_membership_requests_no_results_title'     => esc_html__('No membership requests sent', 'yipnyap'),
    'sent_membership_requests_no_results_text'      => esc_html__('If you send membership requests they will appear here!', 'yipnyap'),
    'wants_to_join'                                 => esc_html__('Wants to Join', 'yipnyap'),

    /**
     * Login Form Popup
     */
    'register'                              => esc_html__('Register', 'yipnyap'),
    'login'                                 => esc_html__('Login', 'yipnyap'),
    'login_and_register'                    => esc_html__('Login &amp; Register', 'yipnyap'),
    'account_login'                         => esc_html__('Account Login', 'yipnyap'),
    'username_or_email'                     => esc_html__('Username or Email', 'yipnyap'),
    'password'                              => esc_html__('Password', 'yipnyap'),
    'remember_me'                           => esc_html__('Remember Me', 'yipnyap'),
    'login_to_your_account'                 => esc_html__('Login to your Account', 'yipnyap'),
    'authenticating'                        => esc_html__('Authenticating...', 'yipnyap'),
    'wrong_user_message'                    => esc_html__('Wrong username or password.', 'yipnyap'),
    'generic_error'                         => esc_html__('An error has ocurred. Please try again later.', 'yipnyap'),
    'create_your_account'                   => esc_html__('Create your Account!', 'yipnyap'),
    'your_email'                            => esc_html__('Your Email', 'yipnyap'),
    'username'                              => esc_html__('Username', 'yipnyap'),
    'repeat_password'                       => esc_html__('Repeat Password', 'yipnyap'),
    'register_now'                          => esc_html__('Register Now!', 'yipnyap'),
    'registering'                           => esc_html__('Registering...', 'yipnyap'),
    'registration_complete'                 => esc_html__('Registration Complete!', 'yipnyap'),
    'invalid_email_message'                 => esc_html__('Email entered is invalid', 'yipnyap'),
    'password_mismatch_message'             => esc_html__('Passwords don\'t match, please enter the same password in both fields', 'yipnyap'),
    'username_exists_message'               => esc_html__('Username already exists!, please select another one', 'yipnyap')
  ];
}

?>
