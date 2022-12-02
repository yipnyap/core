<?php
require_once dirname(__FILE__) . '/rest.php';

/**
 * Initialise bitwise arrays
 */
$GetMemberBit = [
    'link' => 1,
    'rank' => 2,
];

/**
 * Get all possible bitwise keys and values and return as array
 *
 * @return array Bitwise values
 * @since hk15
 */
function YipnyapGetBitwiseValues(): array
{
    global $GetMemberBit;

    return [
        'GetMember' => $GetMemberBit,
    ];
}

/**
 * Get member data by ID
 *
 * @param int $member_id Member ID.
 * @return array Member data.
 * @since hk15
 * @author Rekkisomo
 * @package Yipnyap
 *
 * @see yipnyap_members_get
 */
function YipnyapGetMember(int|string $member_id, int $bitwise = 0x0): array
{
    global $GetMemberBit;

    /**
     * Check if member_id is an ID, or a username. If it's a username, get the ID.
     */
    if (!preg_replace('/[^0-9]/', '', $member_id)) {
        $member_id = str_replace('@', '', $member_id);
        $member_by_login = get_user_by('login', $member_id);
        if ($member_by_login) {
            $member_id = $member_by_login->ID;
        } else {
            return [
                'code' => 404,
                'error' => 'Member not found.',
            ];
        }
    }

    $memberOld = yipnyap_members_get(['include' => [$member_id]])[0];

    // TODO: Deperecate "mention_name" in the future.
    $member = [
        "id" => $memberOld['id'],
        "username" => $memberOld['mention_name'],
        "avatar" => $memberOld['avatar_url'],
    ];

    /**
     * Check if member is verified, then add "verified" to the member array.
     */
    if ($memberOld['verified']) {
        $member['verified'] = true;
    }

    /**
     * Compare bitwise with $GetMemberBit for each key.
     * If the bitwise is set, then add the key to the member array.
     */
    foreach ($GetMemberBit as $key => $value) {
        if ($bitwise & $value) {
            $member[$key] = $memberOld[$key];
        }
    }

    return $member;
}
