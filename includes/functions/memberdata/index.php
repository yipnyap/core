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
function YipnyapGetMember(int $member_id, int $bitwise = 0x0): array
{
    global $GetMemberBit;
    $memberOld = yipnyap_members_get(['include' => [$member_id]])[0];

    // TODO: Deperecate "mention_name" in the future.
    $member = [
        "id" => $memberOld['id'],
        "username" => $memberOld['mention_name'],
        "avatar" => $memberOld['avatar_url'],
    ];

    // Check if the member is verified.
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
