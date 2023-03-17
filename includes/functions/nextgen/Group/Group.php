<?php

namespace Yipnyap;

use Exception;

/**
 * Yipnyap Group class. Manages groups, group members, and other group-related
 * functions.
 *
 * @package    Yipnyap
 * @subpackage Group
 * @since      1.0.0
 * @version    1.0.0
 * @access     public
 */
class Group {
    public int $GroupID;
    public string $GroupType;
    public string $GroupStatus = 'active';
    public string $GroupPrivacy = 'public';
    public string $GroupCreatorID;
    public object $GroupMeta;
    public array $CurrentUserRoles = [];

    /**
     * Check the constructor for a provided group.
     *
     * @param int|string $group_id The group ID.
     *                             Default is 0 (create new group).
     * @throws Exception
     */
    public function __construct(int|string $group_id = 0, bool $dontGetMeta = false) {
        if ($group_id) {
            $this->GroupID = (int) $group_id;

            if (!$dontGetMeta) {
                $this->GetGroupMeta();
            }
        }
    }

    /**
     * Process group data for output.
     *
     * @param int|string|null $id
     * @throws Exception
     */
    public function GetGroupMeta(int|string $id = null): void {
        if (empty($id)) $id = $this->GroupID;
        $BPGroup = groups_get_group($id);

        if (empty($BPGroup->id)) {
            throw new Exception('Group not found.');
        }

        $BPGroup->privacy = $BPGroup->status;
        unset($BPGroup->status);

        $this->GroupPrivacy = $BPGroup->privacy;

        // Convert date strings to unix timestamps.
        $BPGroup->date_created = strtotime($BPGroup->date_created);

        // Remove useless properties.
        unset($BPGroup->enable_forum);
        unset($BPGroup->args);

        if (str_replace('-', ' ', $BPGroup->slug) === $BPGroup->name) {
            unset($BPGroup->slug);
        }

        if (empty($BPGroup->description)) {
            unset($BPGroup->description);
        }

        if (empty($BPGroup->parent_id)) {
            unset($BPGroup->parent_id);
        }

        // Add group banner & avatar.
        $BPGroup->banner = bp_attachments_get_attachment('url', [
            'item_id' => $BPGroup->id,
            'object_dir' => 'groups',
        ]);

        $BPGroup->avatar = bp_core_fetch_avatar([
            'item_id' => $BPGroup->id,
            'object' => 'group',
            'type' => 'full',
            'html' => false,
        ]);

        // Add group counts
        $BPGroup->meta = [
            'members' => [
                'count' => groups_get_total_member_count($BPGroup->id),
                'active' => groups_get_group_members([
                    'group_id' => $BPGroup->id,
                    'exclude_admins_mods' => false,
                    'count_total' => true,
                    'type' => 'online',
                ])['count'],
                // Get group's terminology via meta.
                'term' => $BPGroup->meta['member_terminology'] ?? 'member',
            ],
        ];

        // Use MemberData to get group members
        foreach (groups_get_group_members([
            'group_id' => $BPGroup->id,
            'exclude_admins_mods' => false,
        ])['members'] as $member) {
            $memberBuild = YipnyapGetMember($member->id);

            if ($memberBuild['id'] === $BPGroup->creator_id) {
                $memberBuild['role'] = 'Leader';
            } else {
                $memberBuild['role'] = $member->is_admin ? 'Admin' : ($member->is_mod ? 'Mod' : null);
            }
            $memberBuild['date_joined'] = strtotime($member->date_modified);

            $BPGroup->meta['members']['data'][] = $memberBuild;
        }

        // Sort members by date joined, and by role alphabetically.
        usort($BPGroup->meta['members']['data'], function ($a, $b) {
            if ($a['date_joined'] === $b['date_joined']) {
                return $a['role'] <=> $b['role'];
            }
            return $a['date_joined'] <=> $b['date_joined'];
        });

        // Add 'is_member' property to group
        $BPGroup->meta['members']['is_member'] = groups_is_user_member(get_current_user_id(), $BPGroup->id);

        // Check if current user is mod or admin
        $BPGroup->meta['members']['is_mod'] = groups_is_user_mod(get_current_user_id(), $BPGroup->id);
        $BPGroup->meta['members']['is_admin'] = groups_is_user_admin(get_current_user_id(), $BPGroup->id);

        $this->GroupMeta = $BPGroup;
    }

    /**
     * Get user's roles in the group.
     *
     * @param int|null $user_id
     * @return array
     * @since ui2
     */
    public function GetUserRoles(int|null $user_id = null): array {
        $roles = [];
        $user_id = $user_id ?? get_current_user_id();

        // If the current user isn't in the group, return an empty array.
        if (!groups_is_user_member($user_id, $this->GroupID)) {
            return $roles;
        }

        $IsUserMember = groups_is_user_member($user_id, $this->GroupID);
        $IsUserAdmin = groups_is_user_admin($user_id, $this->GroupID);
        $IsUserMod = groups_is_user_mod($user_id, $this->GroupID);
        $IsUserCreator = groups_is_user_creator($user_id, $this->GroupID);
        $IsUserBanned = groups_is_user_banned($user_id, $this->GroupID);
        $IsUserPending = groups_is_user_pending($user_id, $this->GroupID);
        $IsUserInvited = groups_check_user_has_invite($user_id, $this->GroupID);

        if ($IsUserMember) $roles[] = 'member';
        if ($IsUserAdmin) $roles[] = 'admin';
        if ($IsUserMod) $roles[] = 'mod';
        if ($IsUserCreator) $roles[] = 'owner';
        if ($IsUserBanned) $roles[] = 'banned';
        if ($IsUserPending) $roles[] = 'pending';
        if ($IsUserInvited) $roles[] = 'invited';

        if ($user_id === get_current_user_id()) {
            $this->CurrentUserRoles = $roles;
        }

        return $roles;
    }

    /**
     * Create a new group.
     *
     * @param array $group {
     * @type string $name The group name.
     * @type string $description The group description.
     * @type string $parent_id The parent group ID.
     * @type string $type The group type.
     * }
     * @return int
     * @throws Exception
     */
    public function CreateGroup(array $group): int {
        $type = $group['type'] ?? 'group';
        $this->GroupCreatorID = get_current_user_id();
        $this->GroupType = $type;

        if (!$this->GroupCreatorID) {
            throw new Exception('You must be logged in to create a group.');
        }

        $groupBuild = [
            'creator_id' => $this->GroupCreatorID,
            'name' => $group['name'],
            'description' => $group['description'],
            'status' => $this->GroupPrivacy, // bp calls privacy 'status'
        ];

        // Check for parent group, and check if user is allowed to create a sub-group of that parent.
        if ($group['parent_id']) {
            $parentGroup = groups_get_group($group['parent_id']);
            if ($parentGroup->creator_id == $this->GroupCreatorID) {
                $groupBuild['parent_id'] = $group['parent_id'];
            }
        } else {
            throw new Exception('You are not allowed to create a group in this parent group.');
        }

        $this->GroupID = groups_create_group($groupBuild);
        if ($this->GroupID) {
            $this->GetGroupMeta();
            return $this->GroupMeta->id;
        } else {
            return false;
        }
    }
}