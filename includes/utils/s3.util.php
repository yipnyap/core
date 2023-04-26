<?php
// S3 functions
use Aws\S3\S3Client;

$s3 = new S3Client([
    'region'  => DO_SPACES_REGION,
    'version' => 'latest',
    'credentials' => [
        'key'    => DO_SPACES_KEY,
        'secret' => DO_SPACES_SECRET,
    ]
]);

function S3UserContentUpload(string $userID, string $file, string $E2Parent): string {
    global $s3;

    // Key should be something like: <user_id>/<E2Object>/<E2ID>.<extension>
    $E2ID = E2IDCreate('Post', 'CONTENT_IMAGE', $E2Parent);
    $key = $userID . '/Post/' . $E2ID . '.' . pathinfo($file, PATHINFO_EXTENSION);

    $result = $s3->putObject([
        'Bucket' => DO_SPACES_BUCKET,
        'Key'    => $key,
        'SourceFile' => $file,
        'ACL' => 'public-read',
    ]);

    return $result['ObjectURL'];
}