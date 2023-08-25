<?php

namespace Yipnyap;

use Exception;

/**
 * Searches database tables (excluding specified in $exclude), with each table having different columns to search:
 * - users: username, and on meta: athandle, bio
 * - posts: content, user ID linked to a user, and on meta: blocks
 * - groups: name, slug, description, creator ID linked to a user
 */
class Search
{
    /**
     * @var array
     */
    private $exclude = [];

    /**
     * @var array
     */
    public $results = [];

    /**
     * @var array
     */
    private $search = [];

    /**
     * @var array
     */
    public $problems = [];

    /**
     * constructor
     */
    public function __construct($exclude = []) {
        $this->exclude = $exclude;

        $this->search = [
            'users' => [
                'user_login',
                'user_nicename',
                'meta' => [
                    'athandle',
                    'bio'
                ]
            ],
            'posts' => [
                'content',
                'meta' => [
                    'blocks'
                ]
            ],
            'groups' => [
                'name',
                'slug',
                'description'
            ]
        ];
    }

    /**
     * @param string $query
     * @return array
     * @throws Exception
     */
    public function search(string $query): array
    {
        $query = trim($query);
        $query = preg_replace('/\s+/', ' ', $query);

        foreach ($this->search as $table => $columns) {
            if (in_array($table, $this->exclude)) {
                continue;
            }

            $this->results[$table] = [];

//            if ($table === 'users') {
//                $metaQuery = [];
//                foreach ($columns['meta'] as $meta) {
//                    $metaQuery['relation'] = 'OR';
//                    $metaQuery[] = [
//                        'key' => $meta,
//                        'value' => $query,
//                        'compare' => 'LIKE'
//                    ];
//                }
//                // we can just use wordpress
//                $userQuery = new \WP_User_Query([
//                    'search' => '*' . $query . '*',
//                    'search_columns' => [
//                        'user_login',
//                        'user_nicename',
//                        'display_name',
//                    ],
//                    'fields' => 'all',
//                    'number' => 10
//                ]);
//
//                $userQueryMeta = new \WP_User_Query([
//                    'meta_query' => $metaQuery,
//                    'fields' => 'id',
//                    'number' => 10
//                ]);
//
//                $users = array_merge($userQuery->get_results(), $userQueryMeta->get_results());
//                $users = array_unique($users);
//                foreach ($users as $user) {
//                    $userdata = YipnyapGetMember($user, null, false, [], true);
//                    if (empty($userdata)) continue;
//
//                    $this->results[$table][] = $userdata;
//                }
//            }

            foreach ($columns as $column) {
                // Check if $columns is meta, and if so, all of it's children are meta_keys
                // @todo: probably a better way to do this without reusing code.
                if (is_array($column)) {
                    /**
                     * users table meta is wp_usermeta
                     * posts table meta is wp_bp_activity_meta
                     * groups table meta is wp_bp_groups_groupmeta
                     */
                    switch ($table) {
                        case 'users':
                            $meta_table = 'wp_usermeta';
                            break;
                        case 'posts':
                            $meta_table = 'wp_bp_activity_meta';
                            break;
                        case 'groups':
                            $meta_table = 'wp_bp_groups_groupmeta';
                            break;
                    }

                    if (empty($meta_table)) {
                        $this->problems[] = 'No meta table found for ' . $table;
                        continue;
                    }

                    foreach ($column as $meta) {
                        $search = $this->searchColumn($meta_table, $meta, $query);

                        if (empty($search)) {
                            $this->problems[] = 'No results found for ' . $table . ' ' . $meta;
                            continue;
                        }

                        $this->results[$table] = array_merge($this->results[$table], $search);
                    }
                } else {
                    switch ($table) {
                        case 'users':
                            $db_table = 'wp_users';
                            break;
                        case 'posts':
                            $db_table = 'wp_bp_activity';
                            break;
                        case 'groups':
                            $db_table = 'wp_bp_groups';
                            break;
                    }

                    $this->results[$table] = array_merge($this->results[$table], $this->searchColumn($db_table, $column, $query));
                    $this->results[$table] = array_unique($this->results[$table], SORT_REGULAR);

                    // if users, build a simple object that would only be used by the command palette
                    if ($table === 'users') {
                        foreach ($this->results[$table] as $key => $user) {
                            $userBuild = [
                                'id' => $user['id'],
                                'username' => $user['username'],
                                'display_name' => $user['display_name'],
                            ];
                            $avatar = get_user_meta($userBuild['id'], 'avatar', true);
                            if (!empty($avatar)) {
                                $userBuild['avatar'] = YIPNYAP_SUPABASE_URL . '/storage/v1/object/public/users/' . $avatar;
                            } else {
                                // get from wp
                                $userBuild['avatar'] = str_replace('/yipnyap.me/', '/api.yipnyap.me/', get_avatar_url($userBuild['id']));
                            }

                            $athandle = get_user_meta($userBuild['id'], 'athandle', true);
                            if (!empty($athandle)) $userBuild['username'] = $athandle;

                            $this->results[$table][$key] = $userBuild;
                        }
                    } elseif ($table === 'groups') {
                        foreach ($this->results[$table] as $key => $group) {
                            $groupBuild = [
                                'id' => $group['id'],
                                'name' => html_entity_decode($group['name']),
                                'slug' => $group['slug'],
                                'description' => html_entity_decode($group['description']),
                                'status' => $group['status'],
                                'avatar' => str_replace('/yipnyap.me/', '/api.yipnyap.me/', bp_core_fetch_avatar([
                                    'item_id' => $group['id'],
                                    'object' => 'group',
                                    'type' => 'full',
                                    'html' => false,
                                ]))
                            ];
                            $this->results[$table][$key] = $groupBuild;
                        }
                    }
                }
            }
        }

        return $this->results;
    }

    /**
     * @param string $table
     * @param string $column
     * @param string $query
     * @return array
     */
    private function searchColumn(string $table, string $column, string $query): array
    {
        global $wpdb;
        // ensure sql injection is not possible
        $wild = '%';
        $query = $wild . $wpdb->esc_like($query) . $wild;
        $exclude = '';
        // select what?
        switch ($table) {
            case 'wp_users':
                $select = 'ID AS id, user_login AS username, display_name';
                foreach ($this->results['users'] as $user) {
                    $exclude .= ' AND ID != ' . $user['id'];
                }
                break;
            case 'wp_bp_activity':
                $select = 'ID AS id, user_id, content, type, hide_sitewide';
                foreach ($this->results['posts'] as $post) {
                    $exclude .= ' AND ID != ' . $post['id'];
                }
                break;
            case 'wp_bp_groups':
                $select = 'ID AS id, creator_id, name, slug, description, status';
                foreach ($this->results['groups'] as $group) {
                    $exclude .= ' AND ID != ' . $group['id'];
                }
                break;
            default:
                $select = 'ID AS id';
                break;
        }

        $query = $wpdb->prepare(
            "SELECT $select
                   FROM %i
                   WHERE %i LIKE %s
                   $exclude
                   LIMIT 10", $table, $column, $query);

        return $wpdb->get_results($query, ARRAY_A);
    }
}