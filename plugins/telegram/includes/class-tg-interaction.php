<?php
class YipnyapTelegram
{
    public $lastError;
    protected $bot_token;
    protected $endpoint;
    private $namespace = "tg_col";

    public function __construct()
    {
        $namespace = get_option($this->namespace);
        $this->bot_token = empty($namespace) ? false : get_option($this->namespace)['bot_token'];
        $this->endpoint = "https://api.telegram.org/bot%s";
    }

    /**
     * Set bot token
     *
     * @param $bot_token
     *
     * @return $this
     */
    public function SetBotToken($bot_token): static
    {
        $this->bot_token = $bot_token;
        return $this;
    }

    /**
     * Get info about bot
     * @return bool | object
     */
    public function GetMe(): object|bool
    {
        $request = $this->MakeRequest("/getMe");

        if (is_wp_error($request)) {
            $this->lastError = __("Ooops! Server failure, try again!", "yipnyap-telegram");
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($request));
        if ($body->ok != 1) {
            $this->lastError = sprintf(esc_html__("%s (Error code %d)", "yipnyap-telegram"), $body->description, $body->error_code);
            return false;
        }

        return $body->result;
    }

    /**
     * Make request
     *
     * @param $route
     * @param $args
     *
     * @return array|WP_Error
     */
    private function MakeRequest($route, $args = array()): WP_Error|array
    {
        $endpoint = $this->GetRoute($route);
        return wp_remote_post($endpoint, array(
            'body' => $args
        ));

    }

    /**
     * Get route URL
     *
     * @param $route
     *
     * @return string
     */
    private function GetRoute($route): string
    {
        $endpoint = sprintf("https://api.telegram.org/bot%s", $this->bot_token);
        return $endpoint . $route;
    }

    /**
     * Send authentication token with Telegram
     *
     * @param $token
     * @param $chat_id bool
     *
     * @return bool
     */

    public function SendTgToken($token, $chat_id = false): bool
    {
        if ($chat_id === false) {
            $chat_id = get_user_meta(get_current_user_id(), "tg_wp_factor_chat_id");
        }

        return $this->Send(sprintf(esc_html__("This is your access code: %s", "yipnyap-telegram"), $token), $chat_id);
    }

    /**
     * Send telegram message
     *
     * @param $msg
     * @param $chat_id
     *
     * @return bool
     */
    public function Send($msg, $chat_id): bool
    {
        $request = $this->MakeRequest("/sendMessage", array(
            'chat_id' => $chat_id,
            'text' => $msg,
            'parse_mode' => 'HTML'
        ));

        if (is_wp_error($request)) {
            $this->lastError = __("Ooops! Server failure, try again!", "yipnyap-telegram");
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($request));

        if ($body->ok == 1) {
            return true;
        }

        $this->lastError = sprintf(__("%s (Error code %d)", $body->description, $body->error_code, "yipnyap-telegram"));
        return false;

    }

    /**
     * Send a User failed login notification to Telegram
     *
     * @param $user_login
     *
     * @return bool
     */
    public function SendTgFailedLogin($user_login): bool
    {
        // Get plugin options
        $options = get_option($this->namespace);

        // Get Chat ID
        $chat_id = $options['chat_id'];

        /**
         * @from 1.2
         * Get IP address behind CloudFlare proxy
         */

        // Get IP from computer attempting to login
        $ip_address = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? wp_unslash($_SERVER["HTTP_CF_CONNECTING_IP"]) : wp_unslash($_SERVER['REMOTE_ADDR']));

        if ($options['show_site_name'] === '1' && $options['show_site_url'] === '1') {
            // Get site name
            $site_name = get_bloginfo('name');

            // Get site URL
            $site_url = home_url();

            // Message with site name
            /* translators: 1. Site name, 2. Site URL, 3. Username, 4. IP address */
            $msg = sprintf(__("Failed attempt to access to the site <strong>%s</strong> (%s) for the user: %s (IP: %s)", "yipnyap-telegram"), $site_name, $site_url, $user_login, $ip_address);
        } elseif ($options['show_site_name'] === '1') {
            // Get site name
            $site_name = get_bloginfo('name');

            // Message with URL
            /* translators: 1. Site name, 2. Username, 3. IP address */
            $msg = sprintf(__("Failed attempt to access to the site <strong>%s</strong> for the user: %s (IP: %s)", "yipnyap-telegram"), $site_name, $user_login, $ip_address);
        } elseif ($options['show_site_url'] === '1') {
            // Get site URL
            $site_url = home_url();

            // Message with URL
            /* translators: 1. Site URL, 2. Username, 3. IP address */
            $msg = sprintf(__("Failed attempt to access to the site %s for the user: %s (IP: %s)", "yipnyap-telegram"), $site_url, $user_login, $ip_address);
        } else {
            // Message just with Username and IP address
            /* translators: 1. Username, 2. IP address */
            $msg = sprintf(__("Failed attempt to access for the user: %s (IP: %s)", "yipnyap-telegram"), $user_login, $ip_address);
        }

        return $this->Send($msg, $chat_id);
    }

}

