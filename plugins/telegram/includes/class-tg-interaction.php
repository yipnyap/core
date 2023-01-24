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
     * @param array $args
     *
     * @return array|WP_Error
     */
    private function MakeRequest($route, array $args = []): WP_Error|array
    {
        $endpoint = $this->GetRoute($route);
        return wp_remote_post($endpoint, [
            'body' => $args
        ]);

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
     * @param $chat_id
     *
     * @return bool
     */

    public function SendTgToken($token, $chat_id): bool
    {
        if (empty($chat_id)) {
            $chat_id = get_user_meta(get_current_user_id(), "tgid");
        }

        return $this->Send(sprintf("🔒 Here's your OTP: %s\n\nDon't share this code! If you didn't request this, <b>reset your password immediately.</b>", $token), $chat_id);
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
        $request = $this->MakeRequest("/sendMessage", [
            'chat_id' => $chat_id,
            'text' => $msg,
            'parse_mode' => 'HTML'
        ]);

        if (is_wp_error($request)) {
            $this->lastError = __("Ooops! Server failure, try again!", "yipnyap-telegram");
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($request));

        if ($body->ok == 1) {
            return true;
        }

        $this->lastError = sprintf(__("%s (Error code %d)", "yipnyap-telegram"), $body->description, $body->error_code);
        return false;
    }

    /**
     * Send a User failed login notification to Telegram
     *
     * @param $user_login
     * @param $chat_id
     * @return bool
     */
    public function SendFailedLogin($user_login, $chat_id): bool
    {
        if (empty($chat_id)) {
            get_user_meta(get_current_user_id(), "tgid", true);
        }

        /**
         * @from 1.2
         * Get IP address behind CloudFlare proxy
         */

        // Get IP from computer attempting to login
        $ip_address = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? wp_unslash($_SERVER["HTTP_CF_CONNECTING_IP"]) : wp_unslash($_SERVER['REMOTE_ADDR']));

        $msg = sprintf(__("❌ Failed attempt for the user: %s (IP: %s)", "yipnyap-telegram"), $user_login, $ip_address);

        return $this->Send($msg, $chat_id);
    }

    /**
     * Send a User successful login notification to Telegram
     *
     * @param $user_login
     * @param $chat_id
     * @return bool
     */
    public function SendSuccessfulLogin($user_login, $chat_id): bool
    {
        if (empty($chat_id)) {
            get_user_meta(get_current_user_id(), "tgid", true);
        }

        /**
         * @from 1.2
         * Get IP address behind CloudFlare proxy
         */

        // Get IP from computer attempting to login
        $ip_address = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? wp_unslash($_SERVER["HTTP_CF_CONNECTING_IP"]) : wp_unslash($_SERVER['REMOTE_ADDR']));

        $msg = sprintf(__("✅ %s was successfully accessed. (IP: %s)", "yipnyap-telegram"), $user_login, $ip_address);

        return $this->Send($msg, $chat_id);
    }
}

