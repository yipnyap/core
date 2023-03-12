<?php
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
                'callback' => [$this, 'get_items'],
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
                'callback' => [$this, 'get_item'],
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
    }

    /**
     * Get a specific group.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     * @since ui2
     */
    public function get_item($request): WP_REST_Response {
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
     * @since ui2
     */
    public function get_items($request): WP_REST_Response {
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
                $args['user_id'] = $request['user_id'] ?? get_current_user_id();
                $args['exclude'] = groups_get_user_groups($args['user_id'])['groups'];
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
}
