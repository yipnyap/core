<?php
/**
 * E2 ID Types & Variants.
 * 'A1' Variant is always considered common.
 *
 * Historically, E2 IDs were ^([0-9][0-9])([A-Z][1-9])([A-Za-z1-9]{12,24})$
 * This is the case for *new* content on Yipnyap, but old content still use IDs
 * that are incremented by 1.
 *
 * Example: 16A1hhhhhhhhhhhh
 * 16: Type of object (Group, User, etc.)
 * A1: Variant of object (differs by type, i.e. group would have a membership variant)
 * hhhhhhhhhhhh: ID of object
 *
 * Each E2 ID can have a "Suffix", which is another ID that is appended to the end of the ID.
 * Example:
 * - A post has the ID: 03A1hmqCJeMCiMYz6apoWkpmscPL
 * - Someone left a comment with the ID: 03I4eywRtSRqOLlssaoax1K (Note the "I4" instead of "A1"!)
 * - The comment is a reply to the post, so the post ID is appended to the end of the comment ID like:
 * 03A1hmqCJeMCiMYz6apoWkpmscPL:I4eywRtSRqOLlssaoax1K
 *
 * Suffixes should generally avoid including the type of object, as it's already defined in the ID. The
 * only time in which the type is in the suffix is when the object needs to be appeneded to another type
 * of object (i.e. An avatar (File) on (:) a profile (User)).
 *
 * Legacy IDs are converted to E2 with just having the type and variant being added to the front. Less than
 * 12 characters + numeric = legacy object.
 */
$E2IDTypes = [
    'Core' => [
        'ID' => '00',
        // Core is inherited by all other types, unless otherwise defined.
        'variants' => [
            'COMMON' => 'A1',
            'LEGACY_CONVERTED' => 'A9',

            // Importing - Suffixed with a User ID, as a user can only have 1 import job
            'IMPORT_JOB' => 'I1',
        ]
    ],
    'User' => [
        'ID' => '01',
        'variants' => [
            'ALTERNATIVE_IDENTITY' => 'A2',
            'AUTOMATED' => 'A3',
        ]
    ],
    'Group' => [
        'ID' => '02',
    ],
    'Post' => [
        'ID' => '03',
        'variants' => [
            // A1: Parent
            'PARENT_IS_OFFICIAL' => 'A2', // Official announcement from Yipnyap or the Yipnyap Foundation
            'PARENT_IS_SECRET' => 'A3', // Drafted post, not yet published
            'PARENT_RELIES_ON_FOLDER' => 'A4', // Post is bundled inside a folder, i.e. some sort of portfolio/gallery

            // Interaction
            'INTERACTION_LIKE' => 'I1', // Like on a parent - not a reaction
            'INTERACTION_HOWLING_ECHO' => 'I2', // Rehowl without quote
            'INTERACTION_HOWLING_POST' => 'I3', // Quote within a rehowl
            'INTERACTION_HOWLING_ALONGSIDE' => 'I4', // Comment within a howl/post - usually alongside a parent ID

            // Reactions -- As reactions are just saved as an ID string, the variant is hot-swapped on change.
            // The ID would be with a User ID suffix, i.e. 01A1hmqCJeMCiMYz6apoWkpmscPL:03R1
            'REACTION_SLOT_1' => 'R1',
            'REACTION_SLOT_2' => 'R2',
            'REACTION_SLOT_3' => 'R3',
            'REACTION_SLOT_4' => 'R4',
            // Premium Slots - available to Partners
            'REACTION_SLOT_5' => 'R5',
            'REACTION_SLOT_6' => 'R6',
            'REACTION_SLOT_7' => 'R7',
            'REACTION_SLOT_8' => 'R8',

            // Content - Generally only affects uploaded file names, sometimes db objects.
            'CONTENT_IMAGE' => 'C1',
            'CONTENT_VIDEO' => 'C2',
            'CONTENT_AUDIO' => 'C3',
            'CONTENT_WYSIWYG' => 'C4',
        ]
    ]
];

function E2IDTypeIDToName(string $type_id): string {
    global $E2IDTypes;
    foreach ($E2IDTypes as $type_name => $type_data) {
        if ($type_data['ID'] == $type_id) {
            return $type_name;
        }
    }
    return '';
}

function LegacyIDToE2ID(string $legacy_id, string $type, string $variant): string {
    global $E2IDTypes;
    $type_id = $E2IDTypes[$type]['ID'];
    $variant_id = $E2IDTypes[$type]['variants'][$variant];
    return $type_id . $variant_id . $legacy_id;
}

function E2IDCreate(string $type, string $variant, string $suffix = ''): string {
    global $E2IDTypes;
    $type_id = $E2IDTypes[$type]['ID'];
    $variant_id = $E2IDTypes[$type]['variants'][$variant];
    $random_id = E2IDRandomID();
    $base_id = $type_id . $variant_id . $random_id;

    // If suffix starts with ':' then it's a child ID, if it ends with ':' then it's a parent ID.
    if (str_starts_with($suffix, ':')) {
        $base_id .= $suffix;
    } elseif (str_ends_with($suffix, ':')) {
        $base_id = $suffix . $base_id;
    }

    return $base_id;
}

function E2IDRandomID(): string {
    // Should match the regex: ^([A-Za-z1-9]{12,24})$
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $characters_length = strlen($characters);
    $random_id = '';

    // Random ID is between 12 and 24 characters long.
    $random_id_length = rand(12, 24);
    for ($i = 0; $i < $random_id_length; $i++) {
        $random_id .= $characters[rand(0, $characters_length - 1)];
    }

    return $random_id;
}
