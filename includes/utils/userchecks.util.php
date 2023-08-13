<?php
function YipnyapUtilCheckUsernameValid(string $username): array
{
    // Lowercase, strip spaces
    $username = strtolower(str_replace(' ', '', $username));

    /*
     * Read reserved.json, check if username contains it
     */
    $reservedUsernames = json_decode(file_get_contents('reserved.json', true), true);
    foreach ($reservedUsernames as $reservedUsername) {
        if (stripos($username, $reservedUsername) === 0) {
            return [
                'success' => false,
                'code' => 400,
                'message' => 'Username is invalid - contains a restricted phrase at a restricted point.',
         // v Blast: this looks like a sad face
            ];
        }
    }

    /*
     * ^(?=.{4,12}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$
     *  └─────┬────┘└───┬──┘└─────┬─────┘└─────┬─────┘ └───┬───┘
     *        │         │         │            │           no _ or . at the end
     *        │         │         │            │
     *        │         │         │            allowed characters
     *        │         │         │
     *        │         │         no __ or _. or ._ or .. inside
     *        │         │
     *        │         no _ or . at the beginning
     *        │
     *        username is 3-12 characters long
     */
    $usernameRegexCheck = preg_match('/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/', $username);
    if (!$usernameRegexCheck) {
        return [
            'success' => false,
            'code' => 400,
            'message' => 'Username cannot be used.',
        ];
    } else {
        return [
            'success' => true,
            'data' => $username,
        ];
    }
}