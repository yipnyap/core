<?php

use JetBrains\PhpStorm\NoReturn;

final class YipnyapTelegramLinkage
{
    /**
     * Get an instance
     *
     * @var YipnyapTelegramLinkage
     */
    private static $instance;

    /**
     * Namespace for prefixed setting
     *
     * @var string
     */
    private string $namespace = "tg_col";

    /**
     * Cookie Name
     *
     * @var string
     */
    private string $cookie_name = "auth_tg_cookie";

    /**
     * Check cookie Name
     *
     * @var string
     */
    private string $check_cookie_name = "check_tg_cookie";

    /**
     * @var YipnyapTelegram
     */
    private YipnyapTelegram $telegram;

    /**
     * Get WP Factor Telegram
     *
     * @return YipnyapTelegramLinkage
     */
    public static function GetInstance(): YipnyapTelegramLinkage
    {
        if (empty(self::$instance)
            && !(self::$instance instanceof YipnyapTelegramLinkage)
        ) {
            self::$instance = new YipnyapTelegramLinkage;
            self::$instance->Includes();
            self::$instance->telegram = new YipnyapTelegram;
            self::$instance->AddHooks();

            do_action("wp_factor_telegram_loaded");
        }

        return self::$instance;
    }

    /**
     * Include classes
     */
    public function Includes(): void
    {
        require_once(dirname(WP_FACTOR_TG_FILE)
            . "/includes/class-tg-interaction.php");
    }

    /**
     * Add hooks
     */
    public function AddHooks(): void
    {
        if (is_admin()) {
            add_action('admin_init', [$this, 'TGSettingsInit']);
            add_action("admin_menu", [$this, 'LoadAdminMenu']);
            add_filter("plugin_action_links_"
                . plugin_basename(WP_FACTOR_TG_FILE),
                [$this, 'ActionLink']);
            add_action('updated_option', [$this, 'DeleteTransients'],
                10, 3);
        }

        if (!$this->IsValidBot()) {
            add_action('admin_notices',
                [$this, 'InvalidBotError']);
        }

        if ($this->IsValidBot() && !$this->ChatIDExists()) {
            add_action('admin_notices',
                [$this, 'ChatIDMissingError']);
        }

        add_action('admin_enqueue_scripts', [$this, 'EnqueueScripts']);
        add_action('admin_footer', [$this, 'HookIntoFooter']);
        add_action('wp_ajax_token_check', [$this, 'CheckValidBotToken']);
        add_action('wp_ajax_check_bot', [$this, 'CheckValidBot']);
    }

    public function IsValidBot(): bool
    {
        $valid_bot_transient = WP_FACTOR_TG_GETME_TRANSIENT;

        if (($IsValidBot = get_transient($valid_bot_transient))
            === false
        ) {
            $IsValidBot = $this->telegram->GetMe() !== false;
            var_dump($IsValidBot);
            set_transient($valid_bot_transient, $IsValidBot, 60 * 60 * 24);
        }

        return boolval($IsValidBot);
    }

    public function ChatIDExists($user_id = false): bool
    {
        $chat_id = $this->GetUserChatID($user_id);

        return $chat_id !== false;
    }

    public function GetUserChatID($user_id = false): string
    {
        if ($user_id === false) {
            $user_id = get_current_user_id();
        }

        return get_the_author_meta("tgid", $user_id);
    }

    /**
     * Show telegram login
     *
     * @param $user_login
     * @param $user
     */
    public function ShowTGLogin($user_login, $user): void
    {
        if (get_option($this->namespace)['enabled'] === '1'
            && get_user_meta($user->ID, 'tgid') !== 0
        ) {
            wp_clear_auth_cookie();
            $this->ShowTwoFactorLogin($user);
            exit;
        }
    }

    /**
     * Show to factor login html
     *
     * @param $user
     */
    private function ShowTwoFactorLogin($user): void
    {
        $auth_code = $this->GetAuthCode();

        setcookie($this->cookie_name, null, strtotime('-1 day'));
        setcookie($this->cookie_name, sha1($auth_code),
            time() + (60 * 20));

        $chat_id = $this->GetUserChatID($user->ID);
        $this->telegram->SendTgToken($auth_code, $chat_id);

        $redirect_to = isset($_REQUEST['redirect_to'])
            ? wp_sanitize_redirect($_REQUEST['redirect_to']) : wp_unslash($_SERVER['REQUEST_URI']);

        $this->LoginHTML($user, $redirect_to);
    }

    /**
     * Get authentication code
     *
     * @param int $length
     *
     * @return string
     */
    private function GetAuthCode(int $length = 5): string
    {
        $pool = array_merge(range(0, 9), range('a', 'z'),
            range('A', 'Z'));

        $key = "";

        for ($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }

        return $key;
    }

    /**
     * Login HTML Page
     *
     * @param          $user
     * @param          $redirect_to
     * @param string $error_msg
     */
    private function LoginHTML($user, $redirect_to, string $error_msg = ''): void
    {
        $rememberme = 0;
        if (isset($_REQUEST['rememberme']) && $_REQUEST['rememberme']) {
            $rememberme = 1;
        }

        login_header();

        if (!empty($error_msg)) {
            echo '<div id="login_error"><strong>' . esc_html($error_msg)
                . '</strong><br /></div>';
        }
        // Filter hook to add a custom logo to the 2FA login screen
        $plugin_logo = apply_filters('two_factor_login_telegram_logo',
            plugins_url('assets/img/plugin_logo.png', WP_FACTOR_TG_FILE));
        ?>

        <style>
            body.login div#login h1 a {
                background-image: url("<?php echo esc_url($plugin_logo); ?>");
            }
        </style>

        <form name="validate_tg" id="loginform" action="<?php
        echo esc_url(site_url('wp-login.php?action=validate_tg',
            'login_post')); ?>" method="post" autocomplete="off">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('ajax-login-tg'); ?>">
            <input type="hidden" name="wp-auth-id" id="wp-auth-id" value="<?php
            echo esc_attr($user->ID); ?>"/>
            <input type="hidden" name="redirect_to" value="<?php
            echo esc_attr($redirect_to); ?>"/>
            <input type="hidden" name="rememberme" id="rememberme" value="<?php
            echo esc_attr($rememberme); ?>"/>

            <?php
            $this->AuthenticationHTML(); ?>
        </form>

        <p id="backtoblog">
            <a href="<?php
            echo esc_url(home_url('/')); ?>" title="<?php
            __("Are you lost?", "yipnyap-telegram"); ?>"><?php
                echo sprintf(__('&larr; Back to %s',
                    'yipnyap-telegram'),
                    get_bloginfo('title', 'display')); ?></a>
        </p>

        <?php
        do_action('login_footer'); ?>
        <div class="clear"></div>
        <?php
    }

    /**
     * Authentication page
     */
    private function AuthenticationHTML(): void
    {
        require_once(ABSPATH . '/wp-admin/includes/template.php');
        ?>

        <p class="notice notice-warning">
            <?php
            _e("Enter the code sent to your Telegram account.",
                "yipnyap-telegram");
            ?>
        </p>
        <p>
            <label for="authcode" style="padding-top:1em">
                <?php
                _e("Authentication code:", "yipnyap-telegram");
                ?>
            </label>
            <input type="text" name="authcode" id="authcode" class="input"
                   value="" size="5"/>
        </p>
        <?php
        submit_button(__('Login with Telegram',
            'yipnyap-telegram'));
    }

    /**
     * Validate telegram auth code login
     */
    public function ValidateAuthCode(): void
    {

        if (!wp_verify_nonce($_POST['nonce'], 'ajax-login-tg')) {
            return;
        }

        if (!isset($_POST['wp-auth-id'])) {
            return;
        }

        $user = get_userdata($_POST['wp-auth-id']);
        if (!$user) {
            return;
        }

        if (true !== $this->ValidAuthCode($_REQUEST['authcode'])) {
            do_action('wp_factor_telegram_failed', $user->user_login);

            $auth_code = $this->GetAuthCode();

            setcookie($this->cookie_name, null, strtotime('-1 day'));
            setcookie($this->cookie_name, sha1($auth_code),
                time() + (60 * 20));

            $chat_id = $this->GetUserChatID($user->ID);
            $this->telegram->SendTgToken($auth_code, $chat_id);

            $this->LoginHTML($user, $_REQUEST['redirect_to'],
                __('Wrong verification code, we just sent a new code, please try again!',
                    'yipnyap-telegram'));
            exit;
        }

        $rememberme = false;
        if (isset($_REQUEST['rememberme']) && $_REQUEST['rememberme']) {
            $rememberme = true;
        }

        wp_set_auth_cookie($user->ID, $rememberme);

        $redirect_to = apply_filters('login_redirect',
            $_REQUEST['redirect_to'], $_REQUEST['redirect_to'], $user);
        wp_safe_redirect($redirect_to);

        exit;
    }

    private function ValidAuthCode($authcode, $cookie = false): bool
    {
        if ($cookie === false) {
            $cookie = $this->cookie_name;
        }

        if ($_COOKIE[$cookie] === sha1($authcode)) {
            return true;
        }

        return false;
    }

    public function TGConfig(): void
    {
        require(dirname(WP_FACTOR_TG_FILE) . "/sections/configure_tg.php");
    }

    public function LoadAdminMenu(): void
    {
        add_options_page(__("Two-Factor Authentication with Telegram",
            "yipnyap-telegram"),
            __("Two-Factor Authentication with Telegram",
                "yipnyap-telegram"), "manage_options", "tg-conf",
            [
                $this,
                "TGConfig",
            ]);
    }

    public function DeleteTransients($option_name, $old_value, $new_value): void
    {
        if ($this->namespace === $option_name) {
            delete_transient(WP_FACTOR_TG_GETME_TRANSIENT);
        }
    }

    public function TGSettingsInit(): void
    {
        register_setting($this->namespace, $this->namespace);

        add_settings_section($this->namespace . '_section',
            __('Telegram Configuration', "yipnyap-telegram"), '',
            $this->namespace . '.php');

        $field_args = [
            'type' => 'text',
            'id' => 'bot_token',
            'name' => 'bot_token',
            'desc' => __('Bot Token', "yipnyap-telegram"),
            'std' => '',
            'label_for' => 'bot_token',
            'class' => 'css_class',
        ];

        add_settings_field('bot_token',
            __('Bot Token', "yipnyap-telegram"), [
                $this,
                'RenderSetting',
            ], $this->namespace . '.php', $this->namespace . '_section',
            $field_args);

        $field_args = [
            'type' => 'text',
            'id' => 'chat_id',
            'name' => 'chat_id',
            'desc' => __('Chat ID (Telegram) for failed login report.',
                "yipnyap-telegram"),
            'std' => '',
            'label_for' => 'chat_id',
            'class' => 'css_class',
        ];

        add_settings_field('chat_id',
            __('Chat ID', "yipnyap-telegram"), [
                $this,
                'RenderSetting',
            ], $this->namespace . '.php', $this->namespace . '_section',
            $field_args);

        $field_args = [
            'type' => 'checkbox',
            'id' => 'enabled',
            'name' => 'enabled',
            'desc' => __('Select this checkbox to enable the plugin.',
                'yipnyap-telegram'),
            'std' => '',
            'label_for' => 'enabled',
            'class' => 'css_class',
        ];

        add_settings_field('enabled',
            __('Enable plugin?', 'yipnyap-telegram'), [
                $this,
                'RenderSetting',
            ], $this->namespace . '.php', $this->namespace . '_section',
            $field_args);

        $field_args = [
            'type' => 'checkbox',
            'id' => 'show_site_name',
            'name' => 'show_site_name',
            'desc' => __('Select this checkbox to show site name on failed login attempt message.<br>This option is useful when you use same bot in several sites.',
                'yipnyap-telegram'),
            'std' => '',
            'label_for' => 'show_site_name',
            'class' => 'css_class',
        ];

        add_settings_field('show_site_name',
            __('Show site name?', 'yipnyap-telegram'), [
                $this,
                'RenderSetting',
            ], $this->namespace . '.php', $this->namespace . '_section',
            $field_args);

        $field_args = [
            'type' => 'checkbox',
            'id' => 'show_site_url',
            'name' => 'show_site_url',
            'desc' => __('Select this checkbox to show site URL on failed login attempt message.<br>This option is useful when you use same bot in several sites.',
                'yipnyap-telegram'),
            'std' => '',
            'label_for' => 'show_site_url',
            'class' => 'css_class',
        ];

        add_settings_field('show_site_url',
            __('Show site URL?', 'yipnyap-telegram'), [
                $this,
                'RenderSetting',
            ], $this->namespace . '.php', $this->namespace . '_section',
            $field_args);
    }

    public function RenderSetting($args): void
    {
        extract($args);

        $option_name = $this->namespace;

        $options = get_option($option_name);
        if (empty($options)) $options = [];
        if (empty($options[$id])) $options[$id] = '';

        /** @var $type */
        /** @var $id */
        /** @var $desc */
        /** @var $class */

        switch ($type) {
            case 'text':
                $options[$id] = stripslashes($options[$id]);
                $options[$id] = esc_attr($options[$id]);
                echo "<input class='regular-text $class' type='text' id='$id' name='"
                    . $option_name . "[$id]' value='$options[$id]' />";

                if ($id == "bot_token") {
                    ?>
                    <button id="checkbot" class="button-secondary"
                            type="button"><?php
                        echo __("Check",
                            "yipnyap-telegram") ?></button>
                    <?php
                }

                echo ($desc != '')
                    ? '<br /><p class="wft-settings-description" id="' . $id
                    . '_desc">' . $desc . '</p>' : "";
                break;

            case 'checkbox':

                $options[$id] = stripslashes($options[$id]);
                $options[$id] = esc_attr($options[$id]);
                ?>
                <label for="<?php
                echo esc_attr($id); ?>">
                    <input class="regular-text <?php
                    echo esc_attr($class); ?>" type="checkbox" id="<?php
                    echo esc_attr($id); ?>" name="<?php
                    echo esc_attr($option_name); ?>[<?php
                    echo esc_attr($id); ?>]" value="1" <?php
                    echo checked(1, $options[$id]); ?> />
                    <?php
                    echo esc_html($desc); ?>
                </label>
                <?php
                break;
            case 'textarea':

                wp_editor(
                    $options[$id],
                    $id,
                    [
                        'textarea_name' => $option_name . "[$id]",
                        'style' => 'width: 200px',
                    ]
                );

                break;
        }
    }

    /**
     * Action links
     *
     * @param $links
     * @return array
     */
    public function ActionLink($links): array
    {
        $plugin_links = [
            '<a href="' . admin_url('options-general.php?page=tg-conf') . '">'
            . __('Settings', 'yipnyap-telegram') . '</a>',
        ];

        return array_merge($plugin_links, $links);
    }

    public function ChatIDMissingError(): void
    {
        if (get_current_screen()->id != "profile") {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php
                    printf(__('Do you want to configure Two-Factor Authentication with Telegram?  <a href="%s">click here</a>!',
                        "yipnyap-telegram"),
                        admin_url("profile.php"));
                    ?></p>
            </div>
            <?php
        }
    }

    public function InvalidBotError(): void
    {
        if (get_current_screen()->id != "settings_page_tg-conf") {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php
                    printf(__('Do you want to configure Two-Factor Authentication with Telegram?  <a href="%s">click here</a>!',
                        "yipnyap-telegram"),
                        admin_url("options-general.php?page=tg-conf")); ?>
                </p>
            </div>
            <?php
        }
    }

    public function EnqueueScripts(): void
    {
        $screen = get_current_screen();
        if (in_array($screen->id, ["profile", "settings_page_tg-conf"])) {
            wp_register_style("tg_lib_css",
                plugins_url("assets/css/wp-factor-telegram-plugin.css",
                    dirname(__FILE__)));
            wp_enqueue_style("tg_lib_css");

            wp_register_script("tg_lib_js",
                plugins_url("assets/js/wp-factor-telegram-plugin.js",
                    dirname(__FILE__)), ['jquery'], '1.0.0', true);

            wp_localize_script("tg_lib_js", "tlj", [

                "ajax_error" => __('Ooops! Server failure, try again! ',
                    'yipnyap-telegram'),
                "checkbot_nonce" => wp_create_nonce('ajax-checkbot-nonce'),
                "sendtoken_nonce" => wp_create_nonce('ajax-sendtoken-nonce'),
                "tokencheck_nonce" => wp_create_nonce('ajax-tokencheck-nonce'),
                "spinner" => admin_url("/images/spinner.gif")
            ]);

            wp_enqueue_script("tg_lib_js");

            wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_script(
                'custom-accordion',
                plugins_url('assets/js/wp-factor-telegram-accordion.js',
                    dirname(__FILE__)),
                ['jquery', 'jquery-ui-core', 'jquery-ui-accordion']
            );


            /*wp_register_style( 'jquery-custom-style',
                plugins_url( '/assets/css/jquery-ui.custom.style.min.css',
                    dirname( __FILE__ ) ), array(), '1', 'screen' );
            wp_enqueue_style( 'jquery-custom-style' );*/

        }
    }

    public function HookIntoFooter(): void
    {
        $screen = get_current_screen();
        if (in_array($screen->id, ["profile", "settings_page_tg-conf"])):

            ?>

            <script>
                (function ($) {

                    $(document).ready(function () {
                        YipnyapTelegramLinkage.init();
                    });

                })(jQuery);
            </script>

        <?php
        endif;
    }

    #[NoReturn] public function CheckValidBot(): void
    {

        $response = [
            'type' => 'error'
        ];

        if (!wp_verify_nonce($_POST['nonce'], 'ajax-checkbot-nonce')) {
            $response['msg'] = __('Security check error',
                'yipnyap-telegram');
            die(json_encode($response));
        }

        if (!isset($_POST['bot_token']) || $_POST['bot_token'] == "") {
            $response['msg'] = __('This bot does not exists.',
                'yipnyap-telegram');
            die(json_encode($response));
        }

        $tg = $this->telegram;
        $me = $tg->SetBotToken($_POST['bot_token'])->GetMe();

        if ($me === false) {
            $response['msg'] = __('Unable to get Bot infos, please retry.',
                'yipnyap-telegram');
            die(json_encode($response));
        }

        $response = [
            'type' => 'success',
            'msg' => __('This bot exists.', 'yipnyap-telegram'),
            'args' => [
                'id' => $me->id,
                'first_name' => $me->first_name,
                'username' => $me->username,
            ],
        ];

        die(json_encode($response));
    }

    #[NoReturn] public function CheckValidBotToken(): void
    {
        $response = [
            'type' => 'error'
        ];

        if (!wp_verify_nonce($_POST['nonce'], 'ajax-sendtoken-nonce')) {
            $response['msg'] = __('Security check error',
                'yipnyap-telegram');
            die(json_encode($response));
        }

        $response['msg'] = __('The token entered is wrong.',
            'yipnyap-telegram');


        if (!isset($_POST['token']) || $_POST['token'] == "") {
            die(json_encode($response));
        }


        if (!$this->ValidAuthCode($_POST['token'],
            $this->check_cookie_name)
        ) {
            $response['msg'] = __('Validation code entered is wrong.',
                'yipnyap-telegram');
        } else {
            $response['type'] = "success";
            $response['msg'] = __("Validation code is correct.",
                'yipnyap-telegram');
        }

        die(json_encode($response));
    }
}
