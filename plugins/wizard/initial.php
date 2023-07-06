<?php
$protocol = $_SERVER['SERVER_PROTOCOL'];
if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol) {
    $protocol = 'HTTP/1.0';
}

header('Content-Type: text/html; charset=utf-8');
?>
    <html lang="en" class="antialiased">
    <head>
        <title>Yipnyap Setup</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 dark:bg-neutral-900">
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 dark:bg-neutral-900 py-6 sm:py-12">
        <div class="relative w-full max-w-md backdrop-blur-lg bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 z-20 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10 dark:bg-neutral-800/75">
            <div class="mx-auto">
                <div class="flex items-center">
                    <img src="<?php echo YIPNYAP_URL ?>/img/logo/unicorn-1-min.png" alt="Yipnyap" class="h-8 w-auto" />
                    <h1 class="ml-4 text-2xl font-bold leading-7 text-neutral-700 dark:text-white">
                        👋
                    </h1>
                </div>

                <div class="pt-8 text-base space-y-4 divide-y divide-gray-300/50 text-neutral-700 dark:text-white">
                    <div class="pb-4 space-y-4">
                        <p>
                            <?php if (isset($_ENV['YIPNYAP_SUPABASE_URL'])) { ?>
                                Yipnyap has updated and needs more information.
                            <?php } else { ?>
                                If you're reading this, then congratulations! Yipnyap is ready to be configured.
                            <?php } ?>
                        </p>
                        <p>
                            When asked for a URL of some sort, leave out the protocol unless strictly required.
                            The protocol your webserver is configured as will be used (Prioritised: HTTPS, HTTP).
                            Connections through Cloudflare Flexible SSL are supported regardless, so you do not
                            need to specify the protocol.
                        </p>
                        <p>
                            When using Cloudflare Flexible SSL, <b>and this is a production server, please make
                                sure to setup a SSL certificate and provide CF with the origin certificate.</b>
                            If this should face real traffic, you should use strict SSL where possible.
                        </p>
                    </div>
                    <form class="pt-8 text-sm space-y-8 divide-y divide-gray-300/50" id="wizard" action="<?php echo YIPNYAP_URL ?>/wizard" method="post">
                        <div class="space-y-4">
                            <!-- "What is the Supabase URL?" input -->
                            <?php if (!isset($_ENV['YIPNYAP_SUPABASE_URL'])) { ?>
                                <div class="flex flex-col">
                                    <label for="supabase_url" class="font-medium text-neutral-900 dark:text-white">
                                        Supabase API URL
                                    </label>
                                    <p class="text-neutral-500 dark:text-neutral-400">
                                        Supabase is required for Yipnyap to work. You can get a free account at
                                        <a href="https://supabase.io" target="_blank" class="text-sky-600 hover:text-sky-700">supabase.io</a>
                                        or run locally.
                                    </p>
                                    <input type="text" name="supabase_url" id="supabase_url" required class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                </div>
                            <?php } ?>

                            <?php if (!isset($_ENV['YIPNYAP_SUPABASE_ANON_KEY'])) { ?>
                                <div class="flex flex-col">
                                    <label for="supabase_key" class="font-medium text-neutral-900 dark:text-white">
                                        Supabase Anonymous Key
                                    </label>
                                    <input type="text" name="supabase_key" id="supabase_key" required class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                </div>
                            <?php } ?>

                            <!-- "What is the Supabase key?" input -->
                            <?php if (!isset($_ENV['YIPNYAP_SUPABASE_SERVICE_KEY'])) { ?>
                                <div class="flex flex-col">
                                    <label for="supabase_key" class="font-medium text-neutral-900 dark:text-white">
                                        Supabase Service Key
                                    </label>
                                    <input type="password" name="supabase_key" id="supabase_key" required class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                </div>
                            <?php } ?>

                            <!-- "What is the Logtail source?" input -->
                            <?php if (!isset($_ENV['YIPNYAP_LOGTAIL_SOURCE_ID'])) { ?>
                                <div class="flex flex-col">
                                    <label for="logtail_source" class="font-medium text-neutral-900 dark:text-white">
                                        Logtail Source ID
                                    </label>
                                    <p class="text-neutral-500 dark:text-neutral-400">
                                        Optional - Logtail is required to view Yipnyap's logs.
                                    </p>
                                    <input type="password" name="logtail_source" id="logtail_source" class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                </div>
                            <?php } ?>

                            <?php if (!isset($_ENV['YIPNYAP_TELEGRAM_BOT_TOKEN'])) { ?>
                                <div class="flex flex-col">
                                    <label for="logtail_source" class="font-medium text-neutral-900 dark:text-white">
                                        Telegram Bot Token
                                    </label>
                                    <p class="text-neutral-500 dark:text-neutral-400">
                                        Telegram is used to send users notifications and 2-factor authentication codes.
                                        Without this, users will be unable to claim their account.
                                    </p>
                                    <input type="password" name="logtail_source" id="logtail_source" class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                </div>
                            <?php } ?>

                            <!-- "Should Yipnyap store keys in database?" checkbox -->
                            <div class="flex">
                                <div class="flex items-center h-5">
                                    <input id="store_keys_in_db" name="store_keys_in_db" type="checkbox" checked class="focus:ring-sky-500 h-4 w-4 text-sky-600 border-gray-300 rounded dark:bg-neutral-800 dark:text-white" />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="store_keys_in_db" class="font-medium text-neutral-900 dark:text-white">
                                        Store all keys in database
                                    </label>

                                    <p class="text-neutral-500 dark:text-neutral-400">
                                        If unchecked, they will be <i>only</i> be stored in /etc/yipnyap.
                                        Regardless, the config file will always override the database. Config
                                        files do not exist on non-*nix systems, or if you're using Docker, or
                                        if Yipnyap cannot write to /etc/yipnyap.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php if (!isset($_ENV['YIPNYAP_WEBPACK_DEV_SERVER'])) { ?>
                            <div class="pt-8 flex flex-col">
                                <label for="webpack_dev_server" class="font-medium text-neutral-900 dark:text-white">
                                    Webpack development server URL
                                </label>
                                <div class="space-y-2 text-neutral-500 dark:text-neutral-400">
                                    <p>
                                        Optional - If you're developing Yipnyap, you can run a local webpack dev server
                                        for live reloading.
                                    </p>
                                    <p>
                                        Regardless of whether you use this, Yipnyap will automatically build the
                                        production assets for you via webpack for the first time after installation.
                                    </p>
                                </div>
                                <input type="text" name="webpack_dev_server" id="webpack_dev_server" class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                            </div>
                        <?php } ?>

                        <div class="pt-8 flex">
                            <div class="flex items-center h-5">
                                <input id="wp_automatic_setup" name="wp_automatic_setup" type="checkbox" checked class="focus:ring-sky-500 h-4 w-4 text-sky-600 border-gray-300 rounded dark:bg-neutral-800 dark:text-white" />
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="wp_automatic_setup" class="font-medium text-neutral-900 dark:text-white">
                                    Automatically setup required WordPress plugins
                                </label>

                                <p class="text-neutral-500 dark:text-neutral-400">
                                    Setup required WordPress plugins automatically as well as all
                                    settings required for Yipnyap to work. If unchecked, you will need to
                                    manually install and configure the plugins before Yipnyap will work.
                                </p>
                            </div>
                        </div>

                        <div class="pt-8 flex">
                            <div class="flex items-center h-5">
                                <input id="setup_as_production" name="setup_as_production" type="checkbox" class="focus:ring-sky-500 h-4 w-4 text-sky-600 border-gray-300 rounded dark:bg-neutral-800 dark:text-white" />
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="setup_as_production" class="font-medium text-neutral-900 dark:text-white">
                                    Treat this Yipnyap install as a production environment.
                                </label>

                                <p class="text-neutral-500 dark:text-neutral-400">
                                    Not recommended unless this is facing the public internet, and you're not developing
                                    Yipnyap. Multiple security features and settings will be enabled if this is checked.
                                    Such as:
                                </p>

                                <ul class="list-disc list-inside text-neutral-500 dark:text-neutral-400">
                                    <li>Enabling 2-factor authentication for all users</li>
                                    <li>Enabling password strength requirements</li>
                                    <li>Enabling password expiration</li>
                                    <li>Enabling password history</li>
                                    <li>Harder API rate limits</li>
                                    <li>Kukiko AI Moderation set to strict</li>
                                    <li>Telegram Linkage to be required to access certain features</li>
                                    <li>Most internal testing pages and API endpoints will be disabled</li>
                            </div>
                        </div>

                        <div class="pt-8">
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                    Next
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php die();
