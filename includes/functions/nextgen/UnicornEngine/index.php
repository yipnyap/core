<?php
/**
 * Yipnyap Unicorn Engine
 *
 * @package Yipnyap
 * @since hk15
 * @author Yipnyap (https://yipnyap.xyz/)
 */

/**
 * Get Primary Accent from User ID or Array
 * @param array|int $userArg
 * @param string $default
 * @return string
 */
function UnicornGetPrimaryAccent(array|int $userArg, string $default = 'var(--color-primary)'): string
{
    if (empty($userArg)) return $default;

    if (is_numeric($userArg)) $userArg = [
        'id' => $userArg
    ];

    if (!isset($userArg['profile_data'])) {
        $userArg['profile_data'] = yipnyap_member_get_xprofile_data($userArg['id']);
    }

    $primaryAccent = yipnyap_members_xprofile_get_field_value($userArg, 'Account_Info_Profile Primary Accent');

    return !empty($primaryAccent) ? $primaryAccent : $default;
}
