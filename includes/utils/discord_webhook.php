<?php
//=======================================================================================================
// Create new webhook in your Discord channel settings and copy&paste URL
//=======================================================================================================

function postDiscordWebhookAsError(array $data): void
{

//=======================================================================================================
// Compose message. You can use Markdown
// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
//========================================================================================================

    $data = $data ?? array(
        'content' => '',
        'title' => '',
        'embeds' => array(
            array(
                'title' => '',
                'description' => '',
                'color' => '',
                'timestamp' => '',
                'fields' => array(
                    array(
                        'name' => '',
                        'value' => '',
                        'inline' => true
                    )
                )
            )
        )
    );

    $json_data = json_encode([
        // Message
        "content" => $data['content'],

        // Embeds Array
        "embeds" => $data['embeds'],

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


    $ch = curl_init( YIPNYAP_OPTIONS['discord_webhook_url'] );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec( $ch );
// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
    curl_close( $ch );
}
