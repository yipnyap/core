<?php
if (isset($_GET['tab'])) {
    $active_tab = sanitize_text_field($_GET['tab']);
} else {
    $active_tab = 'config';
}
?>
<div id="wft-wrap" class="wrap">
    <div class="heading-top">
        <h1><?php _e("Setup", "yipnyap-telegram"); ?>
            - <?php _e("Two Factor Authentication with Telegram", "yipnyap-telegram"); ?></h1>
    </div>

    <div class="wpft-container">
        <?php
        if ($this->IsValidBot() && get_the_author_meta("tgid",
                get_current_user_id()) !== false) :

            $chat_id = get_user_meta(get_current_user_id(), "tgid", true);

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
    </div>
</div>
