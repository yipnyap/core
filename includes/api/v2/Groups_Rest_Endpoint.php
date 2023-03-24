<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace Yipnyap;

// TODO: Convert this into a custom interface. Lot of code that'd be reused over and over.

use Exception;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

require_once YIPNYAP_PATH . '/includes/functions/nextgen/Group/Group.php';

/**
 * /groups/
 */
class Groups_Rest_Endpoint extends WP_REST_Controller {
    /**
     * Constructor.
     *
     * @since ui2
     */
    public function __construct() {
        $this->namespace = 'v2';
        $this->rest_base = '/groups';
    }

    /**
     * Register the plugin routes.
     *
     * @since ui2
     */
    public function register(): void {
        register_rest_route($this->namespace, $this->rest_base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_groups'],
                'args' => array_merge($this->get_collection_params(), [
                    'only' => [
                        'description' => 'Limit result set to groups with one or more specified conditions.',
                        'type' => 'string',
                        'items' => [
                            'type' => 'string',
                            'enum' => ['active', 'not_member', 'member'],
                        ],
                        'default' => 'active',
                    ],
                    'user_id' => [
                        'description' => 'Limit result set to groups of which a specific user is a member.',
                        'type' => 'integer',
                        'default' => 0,
                    ],
                ]),
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_item'],
                'permission_callback' => [$this, 'create_item_permissions_check'],
                'args' => $this->get_endpoint_args_for_item_schema(),
            ],
            'schema' => [$this, 'get_public_item_schema'],
        ]);

        register_rest_route($this->namespace, $this->rest_base . '/(?P<id>[\d]+)', [
            'args' => [
                'id' => [
                    'description' => 'A unique integer ID for the group.',
                    'type' => 'integer',
                ],
            ],
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_group'],
                'args' => [
                    'context' => $this->get_context_param(['default' => 'view']),
                ],
            ],
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_item'],
                'permission_callback' => [$this, 'update_item_permissions_check'],
                'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::EDITABLE),
            ],
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'delete_item'],
                'permission_callback' => [$this, 'delete_item_permissions_check'],
                'args' => [
                    'force' => [
                        'default' => false,
                        'description' => 'Skips trash and purges immediately.',
                        'type' => 'boolean',
                    ],
                ],
            ],
        ]);

        register_rest_route($this->namespace, $this->rest_base . '/(?P<id>[\d]+)/members', [
            'args' => [
                'id' => [
                    'description' => 'A unique integer ID for the group.',
                    'type' => 'integer',
                ],
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'join_group'],
            ],
        ]);

        register_rest_route($this->namespace, $this->rest_base . '/(?P<id>[\d]+)/members/(?P<uid>[\d]+)', [
            'args' => [
                'id' => [
                    'description' => 'A unique integer ID for the group.',
                    'type' => 'integer',
                ],
                'uid' => [
                    'description' => 'A unique integer ID for the user.',
                    'type' => 'integer',
                ],
            ],
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'delete_group_member'],
                'permission_callback' => [$this, 'user_mod_permissions_check'],
            ],
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_group_member'],
                'permission_callback' => [$this, 'user_mod_permissions_check'],
            ],
        ]);
    }

    /**
     * Get a specific group.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     * @since ui2
     */
    public function get_group(WP_REST_Request $request): WP_REST_Response {
        try {
            $group = new Group($request['id']);
            return rest_ensure_response($group->GroupMeta);
        } catch (Exception $e) {
            return new WP_REST_Response(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Get a collection of groups.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     * @throws Exception
     * @since ui2
     */
    public function get_groups(WP_REST_Request $request): WP_REST_Response {
        $args = [
            'sort' => $request['sort'] ?? 'last_activity',
            'per_page' => $request['per_page'],
            'page' => $request['page'],
            'fields' => 'ids',
        ];

        switch ($request['only']) {
            case 'active':
                $args['type'] = 'active';
                break;
            case 'not_member':
                if (empty($request['user_id'])) $request['user_id'] = get_current_user_id();
                // exclude groups that the user is a member of, as string.
                $args['exclude'] = groups_get_user_groups($request['user_id'])['groups'];
                break;
            case 'member':
                $args['user_id'] = get_current_user_id();
                break;
        }

        $BPGroups = groups_get_groups($args)['groups'];
        $groups = [];

        foreach ($BPGroups as $BPGroup) {
            $group = new Group($BPGroup);
            $groups[] = $group->GroupMeta;
        }

        return rest_ensure_response($groups);
    }

    /**
     * Handle a request to kick or ban a member from a group.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     * @throws Exception
     * @since ui2
     */
    public function delete_group_member(WP_REST_Request $request): WP_REST_Response {
        $group = new Group($request['id'], true);
        $currentUserRoles = $group->GetUserRoles();
        $victimUserRoles = $group->GetUserRoles($request['uid']);

        $currentUserCanKick = in_array_any($currentUserRoles, ['admin', 'mod', 'owner']);
        // @todo Custom permissions for banning
        $currentUserCanBan = $currentUserCanKick;

        $victimUserIsStaff = in_array_any($victimUserRoles, ['admin', 'mod', 'owner']);

        // Check if the user is a group admin, mod, or owner
        if ($victimUserIsStaff || !$currentUserCanKick) {
            return new WP_REST_Response(['message' => 'The hierarchy forbids you from doing that.'], 403);
        }

        // Check if the user is a member of the group
        if (empty($victimUserRoles)) {
            return new WP_REST_Response(['message' => 'User is not a member of this pack. Banning users who aren\'t members is not supported yet.'], 404);
        }

        // Check if the user is trying to ban themselves, but allow them to kick themselves
        if ($request['uid'] == get_current_user_id() && $request['ban'] ?? false) {
            return new WP_REST_Response(['message' => 'You can\'t ban yourself.'], 403);
        }

        // Check if the request is `ban: true`
        if (($request['ban'] ?? false) && $currentUserCanBan) {
            $group->BanMember($request['uid']);
            return rest_ensure_response(['message' => 'User banned.']);
        } else {
            // It is already assumed that the user can kick, per the above checks.
            $group->KickMember($request['uid']);
            return rest_ensure_response(['message' => 'User kicked.']);
        }
    }

    /**
     * Handle a request to change a member's role in a group.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     * @throws Exception
     * @since ui2
     */
    public function update_group_member(WP_REST_Request $request): WP_REST_Response {
        $group = new Group($request['id'], true);
        $currentUserRoles = $group->GetUserRoles();
        $victimUserRoles = $group->GetUserRoles($request['uid']);

        $currentUserCanPromote = in_array_any($currentUserRoles, ['admin', 'mod', 'owner']);
        $currentUserCanDemote = in_array_any($currentUserRoles, ['admin', 'owner']);
        $currentUserIsOwner = in_array('owner', $currentUserRoles);

        $victimUserIsHigherUp = in_array_any($victimUserRoles, ['admin', 'owner']);

        // Check if the user is a group admin, mod, or owner, but allow the owner to demote
        if (($victimUserIsHigherUp || !$currentUserCanPromote) && !$currentUserIsOwner) {
            return new WP_REST_Response(['message' => 'The hierarchy forbids you from doing that.'], 403);
        }

        // Check if the user is a member of the group
        if (empty($victimUserRoles)) {
            return new WP_REST_Response(['message' => 'User is not a member of this pack.'], 404);
        }

        // Check if the user is trying to demote themselves
        if ($request['uid'] == get_current_user_id()) {
            return new WP_REST_Response(['message' => 'You can\'t manage yourself.'], 403);
        }

        // Check if the request is `role: member`
        if ($request['role'] == 'member' && $currentUserCanDemote) {
            $success = $group->PromoteMember($request['uid'], 'member');

            if ($success) {
                return rest_ensure_response(['message' => 'User demoted.']);
            } else {
                return new WP_REST_Response(['message' => 'Yipnyap couldn\'t do that.'], 400);
            }
        } else {
            // It is already assumed that the user can promote, per the above checks.
            $success = $group->PromoteMember($request['uid'], $request['role']);

            if ($success) {
                return rest_ensure_response(['message' => 'User promoted.']);
            } else {
                return new WP_REST_Response(['message' => 'Yipnyap couldn\'t do that.'], 400);
            }
        }
    }

    /**
     * Handle a request to join a group.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     * @throws Exception
     */
    public function join_group(WP_REST_Request $request): WP_REST_Response {
        $group = new Group($request['id']);
        $success = $group->JoinGroup();

        // tried a switch statement, but it didn't work...
        if ($success === 'pending') {
            return new WP_REST_Response(['message' => 'Your request to join this pack is pending.'], 202);
        } elseif ($success === 'already_member') {
            return new WP_REST_Response(['message' => 'You are already a member of this pack.'], 409);
        } elseif ($success === 'banned') {
            return new WP_REST_Response(['message' => 'You are banned from this pack.'], 403);
        } elseif ($success === 'forbidden') {
            return new WP_REST_Response(['message' => 'You are not allowed to join this pack.'], 403);
        } elseif ($success === true) {
            return new WP_REST_Response(['message' => 'You have joined this pack.'], 200);
        } else {
            return new WP_REST_Response(['message' => 'There was an error joining this pack.'], 500);
        }
    }

    /**
     * Permission check for user management.
     *
     * @param WP_REST_Request $request
     * @return bool
     * @throws Exception
     */
    public function user_mod_permissions_check(WP_REST_Request $request): bool {
        $group = new Group($request['id'], true);
        $roles = $group->GetUserRoles();

        // check if the user is a group admin, mod, or owner based on current roles array
        return in_array_any($roles, ['admin', 'mod', 'owner']);
    }
}

function in_array_any($needles, $haystack): bool {
    return !empty(array_intersect($needles, $haystack));
}
