<?php
if (isset($_GET['tab'])) {
    $active_tab = sanitize_text_field($_GET['tab']);
} else {
    $active_tab = 'config';
}
?>

    <div id="wft-wrap" class="wrap">

        <div class="heading-top">
            <div class="cover-tg-plugin">
            </div>
            <h1><?php _e("Setup", "yipnyap-telegram"); ?>
                - <?php _e("Two Factor Authentication with Telegram", "yipnyap-telegram"); ?></h1>
        </div>
        <h2 class="wpft-tab-wrapper nav-tab-wrapper">
            <a href="<?php echo admin_url('options-general.php?page=tg-conf&tab=config'); ?>"
               class="nav-tab <?php echo $active_tab == 'config' ? 'nav-tab-active' : ''; ?>"><?php _e("Setup",
                    "yipnyap-telegram"); ?></a>
            <a href="<?php echo admin_url('options-general.php?page=tg-conf&tab=howto'); ?>"
               class="nav-tab <?php echo $active_tab == 'howto' ? 'nav-tab-active' : ''; ?>"><span
                        class="dashicons dashicons-editor-help"></span> <?php _e("FAQ",
                    "yipnyap-telegram"); ?>
            </a>

            <?php

            if ($this->IsValidBot() && get_the_author_meta("tg_wp_factor_chat_id",
                    get_current_user_id()) !== false) {
                ?>

                <a href="<?php echo admin_url('options-general.php?page=tg-conf&tab=suggestions'); ?>"
                   class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>"><span
                            class="dashicons dashicons-heart"></span> <?php _e("Suggestions",
                        "yipnyap-telegram"); ?>
                </a>

                <?php
            }

            ?>

        </h2>

        <div class="wpft-container">

            <?php

            if ($active_tab == "howto") {

                ?>

                <h2><?php _e("FAQ", "yipnyap-telegram"); ?></h2>

                <div id="wpft-howto">
                    <h3 id="first"><?php _e("Bot token", "yipnyap-telegram"); ?></h3>
                    <div>
                        <p>
                            <?php _e('If you want to enable <strong>Two Factor Authentication with Telegram</strong> plugin you need to provide a valid token for a Telegram Bot.',
                                "yipnyap-telegram"); ?>
                            <br/>
                            <?php _e('Have you ever created a bot in Telegram? It\'s so easy!',
                                "yipnyap-telegram"); ?>
                            <br/>

                        <ol>
                            <li>
                                <?php
                                printf(__('Open Telegram and start a conversation with %s',
                                    "yipnyap-telegram"),
                                    '<a href="https://telegram.me/botfather" target="_blank">@BotFather</a>');
                                ?>
                            </li>

                            <li>
                                <?php
                                printf(__('Type command %s to create a new bot',
                                    "yipnyap-telegram"), '<code>/newbot</code>');
                                ?>
                            </li>
                            <li><?php
                                _e('Provide username and name for the new bot.',
                                    'yipnyap-telegram'); ?></li>
                            <li>
                                <?php _e('In the anwser will be your <strong>Bot Token</strong>',
                                    'yipnyap-telegram'); ?>

                                <img style="width:500px;height:auto;"
                                     src="<?php echo plugins_url("/assets/img/help-api-token.png",
                                         WP_FACTOR_TG_FILE); ?>">

                            </li>
                        </ol>
                    </div>
                    <h3><?php _e("Get Chat ID for Telegram user", "yipnyap-telegram"); ?></h3>
                    <div>
                        <p>
                            <?php _e("Chat ID identifies your user profile in Telegram.",
                                "yipnyap-telegram"); ?>
                            <br/>
                            <?php _e("You have no idea what is your Chat ID? Follow these simple steps:",
                                "yipnyap-telegram"); ?>

                        <ol>

                            <li>
                                <?php
                                printf(__('Open Telegram and start a conversation with %s',
                                    "yipnyap-telegram"),
                                    '<a href="https://telegram.me/myidbot" target="_blank">@MyIDBot</a>');
                                ?>
                            </li>

                            <li>
                                <?php
                                printf(__('Type command %s to obtain your Chat ID.',
                                    "yipnyap-telegram"), '<code>/getid</code>');
                                ?>
                            </li>
                            <li>
                                <?php
                                _e("Inside of the answer you'll find your <strong>Chat ID</strong>",
                                    'yipnyap-telegram');
                                ?>
                            </li>

                        </ol>

                        </p>
                    </div>
                    <h3><?php _e("Activation of service", "yipnyap-telegram"); ?></h3>
                    <div>
                        <p>
                            <?php _e('Open a conversation with the created bot that you provided for the plugin and push <strong>Start</strong>',
                                'yipnyap-telegram'); ?>
                            .
                        </p>
                    </div>
                </div>

                <?php

            } else {

                if ($this->IsValidBot() && get_the_author_meta("tg_wp_factor_chat_id",
                        get_current_user_id()) !== false) :

                    $chat_id = get_user_meta(get_current_user_id(), "tg_wp_factor_chat_id", true);

                    if (empty($chat_id)) :

                        ?>

                        <div class="wpft-notice wpft-notice-warning">
                            <p>
                                <span class="dashicons dashicons-editor-help"></span> <?php

                                printf(__('Ok! <a href="%s">It\'s time to set your user</a>.',
                                    "yipnyap-telegram"),
                                    admin_url('profile.php#wptl'));

                                ?>
                            </p>
                        </div>

                    <?php

                    endif;

                else:

                    ?>

                    <div class="wpft-notice wpft-notice-warning">
                        <p>
                            <span class="dashicons dashicons-editor-help"></span> <?php

                            printf(__('First time? <a href="%s">Take a look into the FAQ!</a>',
                                "yipnyap-telegram"),
                                admin_url('options-general.php?page=tg-conf&tab=howto'));

                            ?>
                        </p>
                    </div>

                <?php
                endif;
                ?>

                <!--suppress HtmlUnknownTarget -->
                <form method="post" enctype="multipart/form-data" action="options.php">

                    <?php
                    settings_fields('tg_col');
                    do_settings_sections('tg_col.php');
                    ?>
                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
                    </p>

                </form>

                <?php
            }
            ?>

        </div>

    </div>

<?php do_action("tft_copyright"); ?>
