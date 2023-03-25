<?php
/**
 * /relationships/
 */
require_once YIPNYAP_PATH . '/includes/functions/nextgen/UserRelationship/UserRelationship.php';
use Yipnyap\UserRelationship;

add_action('rest_api_init', function () {
    $Initiator = [
        'required' => true,
        'type' => 'string',
    ];
    $Target = [
        'required' => true,
        'type' => 'string',
    ];
    $InitiatorTarget = [
        'initiator' => $Initiator,
        'target' => $Target,
    ];

    /**
     * GET /relationships/get/<TargetUserID>
     * @return object Relationship data.
     * @since hk15
     */
    register_rest_route('v2', '/relationships/get/(?P<target>\d+)', [
        'methods' => 'GET',
        'callback' => function ($request) {
            if (empty(get_current_user_id())) {
                wp_send_json([
                    'success' => false,
                    'error' => 'Not logged in.',
                ]);
            }
            $result = [];
            $Relationship = new UserRelationship();
            $Relationship->SetRelationshipInfo(get_current_user_id(), $request['target']);
            $result['relationship'] = $Relationship->GetRelationshipInfo();
            $result['success'] = true;
            wp_send_json($result);
        },
    ]);

    /**
     * POST /relationships/follow
     * @param string $initiator Initiator ID.
     * @param string $target Target ID.
     * @return object Relationship data.
     * @since hk15
     */
    register_rest_route('v2', '/relationships/follow', [
        'methods' => 'POST',
        'args' => $Target,
        'callback' => function ($request) {
            if (empty(get_current_user_id())) {
                wp_send_json([
                    'success' => false,
                    'error' => 'Not logged in.',
                ]);
            }
            $success = false;
            $result = [];
            if (!empty($request['target'])) {
                $Relationship = new UserRelationship();
                $Relationship->SetRelationshipInfo(get_current_user_id(), $request['target']);
                $success = $Relationship->CreateFollow();

                $result['relationship'] = $Relationship->GetRelationshipInfo();
            } else {
                $result['error'] = 'Missing target user ID.';
            }
            $result['success'] = $success;
            wp_send_json($result);
        },
    ]);

    /**
     * POST /relationships/unfollow
     * @param string $initiator Initiator ID.
     * @param string $target Target ID.
     * @return object Relationship data.
     * @since hk15
     */
    register_rest_route('v2', '/relationships/unfollow', [
        'methods' => 'POST',
        'args' => $Target,
        'callback' => function ($request) {
            if (empty(get_current_user_id())) {
                wp_send_json([
                    'success' => false,
                    'error' => 'Not logged in.',
                ]);
            }
            $success = false;
            $result = [];
            if (!empty($request['target'])) {
                $Relationship = new UserRelationship();
                $Relationship->SetRelationshipInfo(get_current_user_id(), $request['target']);
                $success = $Relationship->RemoveFollow();

                $result['relationship'] = $Relationship->GetRelationshipInfo();
            } else {
                $result['error'] = 'Missing target user ID.';
            }
            $result['success'] = $success;
            wp_send_json($result);
        },
    ]);

    /**
     * POST /relationships/following
     * @param string $initiator Initiator ID.
     * @param string $target Target ID.
     * @return object Relationship data.
     * @since hk15
     */
    register_rest_route('v2', '/relationships/following', [
        'methods' => 'POST',
        'args' => $Target,
        'callback' => function ($request) {
            if (empty(get_current_user_id())) {
                wp_send_json([
                    'success' => false,
                    'error' => 'Not logged in.',
                ]);
            }
            $success = false;
            $result = [];
            if (!empty($request['target'])) {
                $Relationship = new UserRelationship();
                $Relationship->SetRelationshipInfo(get_current_user_id(), $request['target']);
                $success = true;

                $result['relationship'] = $Relationship->IsFollowing();
            } else {
                $result['error'] = 'Missing target user ID.';
            }
            $result['success'] = $success;
            wp_send_json($result);
        },
    ]);

    /**
     * POST /relationships/mutuals
     * @param string $initiator Initiator ID.
     * @param string $target Target ID.
     * @return object Relationship data.
     * @since hk15
     */
    register_rest_route('v2', '/relationships/mutuals', [
        'methods' => 'POST',
        'args' => $Target,
        'callback' => function ($request) {
            if (empty(get_current_user_id())) {
                wp_send_json([
                    'success' => false,
                    'error' => 'Not logged in.',
                ]);
            }
            $success = false;
            $result = [];
            if (!empty($request['target'])) {
                $Relationship = new UserRelationship();
                $Relationship->SetRelationshipInfo(get_current_user_id(), $request['target']);
                $success = true;

                $result['relationship'] = $Relationship->IsMutual();
            } else {
                $result['error'] = 'Missing target user ID.';
            }
            $result['success'] = $success;
            wp_send_json($result);
        },
    ]);

    /**
     * POST /relationships/friend/request
     * @param string $initiator Initiator ID.
     * @param string $target Target ID.
     * @return object Relationship data.
     * @since hk15
     */
    register_rest_route('v2', '/relationships/friend/request', [
        'methods' => 'POST',
        'args' => $Target,
        'callback' => function ($request) {
            if (empty(get_current_user_id())) {
                wp_send_json([
                    'success' => false,
                    'error' => 'Not logged in.',
                ]);
            }
            $success = false;
            $result = [];
            if (!empty($request['target'])) {
                if (get_current_user_id() === $request['target']) {
                    wp_send_json([
                        'success' => false,
                        'error' => 'Cannot friend yourself.',
                    ]);
                }

                $Relationship = new UserRelationship();
                $Relationship->SetRelationshipInfo(get_current_user_id(), $request['target']);
                $success = $Relationship->CreateFriendRequest();

                $result['relationship'] = $Relationship->GetRelationshipInfo();
            } else {
                $result['error'] = 'Missing target user ID.';
            }
            $result['success'] = $success;
            wp_send_json($result);
        },
    ]);

    /**
     * GET /relationships/friend/request
     * @return object Relationship data.
     * @since hk15
     */
    register_rest_route('v2', '/relationships/friend/request', [
        'methods' => 'GET',
        'callback' => function ($request) {
            if (empty(get_current_user_id())) {
                wp_send_json([
                    'success' => false,
                    'error' => 'Not logged in.',
                ]);
            }
            $result = [];
            $Relationship = new UserRelationship();
            $Relationship->SetRelationshipInfo(get_current_user_id());
            $result['relationship'] = $Relationship->GetFriendRequests();
            $result['success'] = true;
            wp_send_json($result);
        },
    ]);
});
