<?php

/**
 * Get bytes of directory by user id
 * @param $user_id
 * @return int
 */
function YipnyapGetStorageUsage($user_id): int
{
    $user_dir = YIPNYAP_UPLOADS_PATH . '/member/' . $user_id;
    $bytes = 0;
    if (is_dir($user_dir)) {
        $bytes = YipnyapGetDirectorySize($user_dir);
    }
    return $bytes;
}

/**
 * Get bytes of a directory
 *
 * @param $path
 * @return int
 */
function YipnyapGetDirectorySize($path): int
{
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}

function YipnyapFSHumanReadable($bytes, $dec = 2)
{
    $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$dec}f %s", $bytes / (1024 ** $factor), $size[$factor]);
}

