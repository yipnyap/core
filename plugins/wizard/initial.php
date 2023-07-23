<?php
require_once YIPNYAP_PATH . '/includes/utils/s3.util.php';

$protocol = $_SERVER['SERVER_PROTOCOL'];
if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol) {
    $protocol = 'HTTP/1.0';
}

// Check if `resetInstall` is set - if so, delete the config file and reload the page.
if (isset($_GET['resetInstall'])) {
    if (file_exists(YIPNYAP_ENV_PATH)) {
        unlink(YIPNYAP_ENV_PATH);
    }

    header($protocol . ' 302 Found');
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit();
}

$errors = [];
$warnings = [];
$successes = [];

$conf_keys = [
    'supabase_url' => 'YIPNYAP_SUPABASE_URL',
    'supabase_anon_key' => 'YIPNYAP_SUPABASE_ANON_KEY',
    'supabase_service_key' => 'YIPNYAP_SUPABASE_SERVICE_KEY',
    'logtail_source_id' => 'YIPNYAP_LOGTAIL_SOURCE_ID',
    'telegram_bot_token' => 'YIPNYAP_TELEGRAM_BOT_TOKEN',
    'webpack_dev_server' => 'YIPNYAP_WEBPACK_DEV_SERVER',
    'setup_as_production' => 'YIPNYAP_SETUP_AS_PRODUCTION',
];

$conf = file_get_contents(YIPNYAP_ENV_PATH);
if ($conf === false) {
    // Create an empty config file
    $conf = '';
    file_put_contents(YIPNYAP_ENV_PATH, $conf);

    // Change the permissions of the config file so no one but the current user can read/write
    chmod(YIPNYAP_ENV_PATH, 0600);
}

if (!is_writeable(YIPNYAP_ENV_PATH)) $errors[] = YIPNYAP_ENV_PATH . ' is not writeable by web server.';

// Get current wizard status
$wizard_status = getenv('YIPNYAP_WIZARD_STATUS');

// Check config for any missing values, if so, add them to a list
$missing = [];
foreach ($conf_keys as $key => $value) {
    if (preg_match('/^' . $value . '=(.*)$/m', $conf, $matches) === 0) {
        $missing[$key] = $value;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($conf)) {
        echo 'Error: Could not read Yipnyap configuration file. Attempting to create it.<br>';
        // Create the dummy config file
        $conf = "# Yipnyap Configuration File\n";
        $conf .= "# This file is used to store the configuration for Yipnyap.\n\n";
        $conf .= "# Config version - do not change\n";
        $conf .= "YIPNYAP_CONFIG_VERSION=1\n\n";
        $conf .= "YIPNYAP_SUPABASE_URL=\n";
        $conf .= "YIPNYAP_SUPABASE_ANON_KEY=\n";
        $conf .= "YIPNYAP_SUPABASE_SERVICE_KEY=\n";
        $conf .= "YIPNYAP_LOGTAIL_SOURCE_ID=\n";
        $conf .= "YIPNYAP_TELEGRAM_BOT_TOKEN=\n";
        $conf .= "YIPNYAP_WEBPACK_DEV_SERVER=\n";
        $conf .= "YIPNYAP_SETUP_AS_PRODUCTION=\n";
        $conf .= "YIPNYAP_WIZARD_STATUS=\n";
    }

    foreach ($conf_keys as $key => $value) {
        if (isset($_POST[$key])) {
            if ($_POST[$key] === 'on') {
                $_POST[$key] = 'true';
            } elseif ($_POST[$key] === 'off') {
                $_POST[$key] = 'false';
            }

            $conf = preg_replace('/^' . $value . '=(.*)$/m', $value . '=' . $_POST[$key], $conf);
        }
    }

    // Find YIPNYAP_WIZARD_STATUS and set it to 'PREP'
    $conf = preg_replace('/^YIPNYAP_WIZARD_STATUS=(.*)$/m', 'YIPNYAP_WIZARD_STATUS=PREP', $conf);

    // Test the supabase connection - using the subdomain from url
    try {
        putenv("YIPNYAP_SUPABASE_URL={$_POST['supabase_url']}");
        putenv("YIPNYAP_SUPABASE_SERVICE_KEY={$_POST['supabase_service_key']}");
        $supabase = SupabaseUserContentUpload('01A1TESTINGSERVICE', YIPNYAP_PATH . '/style.css');
        if ($supabase['success'] !== true) {
            echo 'Error: Could not connect to Supabase. Please check your Supabase URL and Service Key.<br>';
            exit();
        }
    } catch (Exception $e) {
        echo 'Error: Could not connect to Supabase as an internal error occurred.<br>';
        echo '<br><br>';
        echo $e->getMessage();
        exit();
    }

    // Save the config file
    $file_create = file_put_contents(YIPNYAP_ENV_PATH, $conf);

    if ($file_create === false) {
        echo 'Error: Could not write to Yipnyap configuration file.<br>';
        exit();
    }

    // Reload the page
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

$required_plugins = [
    'ex-social',
    'ex-social-followers',
    'ex-verified',
    'ex-economy',
    'ex-economy-social-integration',
    'vkmedia',
    'vkreact',
    'vkreact-buddypress',
    'yipnyap-buddypress-extension',
    'yp-no-ajax',
    'yapex-wp-die',
    '.git',
];

$plugin_dir = WP_PLUGIN_DIR;
$plugins = scandir($plugin_dir);
$plugins = array_diff($plugins, ['.', '..']);

if ($wizard_status === 'PREP') {
    // If we're here, this worked
    $successes[] = 'Supabase connection is working';

    foreach ($plugins as $plugin) {
        // Just check the folder name
        if (is_dir($plugin_dir . '/' . $plugin)) {
            if (in_array($plugin, $required_plugins)) {
                unset($required_plugins[array_search($plugin, $required_plugins)]);

                if ($plugin === '.git') {
                    $successes[] = 'Plugins are synced with git';
                } else {
                    $successes[] = "$plugin queued for activation";
                }
            } elseif ($plugin === '.git') {
                $errors[] = 'Plugins are not synced with git';
            } else {
                $warnings[] = "$plugin is not queued";
            }
        }
    }

    foreach ($required_plugins as $plugin) {
        $errors[] = "$plugin is required";
    }

    if (empty($errors)) {
        $conf = preg_replace('/^YIPNYAP_WIZARD_STATUS=(.*)$/m', 'YIPNYAP_WIZARD_STATUS=INSTALL', $conf);
        $file_create = file_put_contents(YIPNYAP_ENV_PATH, $conf);
    }
}

if ($wizard_status === 'INSTALL') {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    foreach ($plugins as $plugin) {
        // Just check the folder name
        if (is_dir($plugin_dir . '/' . $plugin)) {
            if (in_array($plugin, $required_plugins)) {
                if ($plugin === '.git') continue;

                // Search each file for the plugin's header without get_plugin_data()
                $plugin_files = scandir($plugin_dir . '/' . $plugin);
                $plugin_files = array_diff($plugin_files, ['.', '..']);

                // Only get php files in the root
                $plugin_files = array_filter($plugin_files, function ($file) {
                    return preg_match('/\.php$/', $file);
                });

                foreach ($plugin_files as $plugin_file) {
                    $plugin_data = file_get_contents($plugin_dir . '/' . $plugin . '/' . $plugin_file);
                    if ($plugin_data === false) {
                        $errors[] = 'Error: Could not read plugin ' . $plugin;
                        continue;
                    }

                    if (preg_match('/[Pp]lugin [Nn]ame:(.*)$/m', $plugin_data, $matches) === 0) continue;

                    $plugin_name = trim($matches[1]);

                    $activate = activate_plugin($plugin_dir . '/' . $plugin . '/' . $plugin_file, '', false, true);
                    if ($activate !== null) {
                        $errors[] = 'Error: Could not activate plugin ' . $plugin_name . ' - ' . str_replace('The plugin does not have a valid header.', 'Filesystem cannot read it.', $activate->get_error_message());
                    } else {
                        $successes[] = 'Activated plugin ' . $plugin_name;

                        unset($required_plugins[array_search($plugin, $required_plugins)]);
                    }
                }

                if (in_array($plugin, $required_plugins)) {
                    $errors[] = 'Error: Could not find plugin header for ' . $plugin;
                }
            }
        }
    }

    if (empty($errors)) {
        // Find YIPNYAP_WIZARD_STATUS and set it to 'DONE'
        $conf = preg_replace('/^YIPNYAP_WIZARD_STATUS=(.*)$/m', 'YIPNYAP_WIZARD_STATUS=DONE', $conf);
        $file_create = file_put_contents(YIPNYAP_ENV_PATH, $conf);
    }
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
        <div class="absolute z-10 inset-0 bg-[url(<?php echo YIPNYAP_URL ?>/img/background/grid.svg)] bg-center dark:invert [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>

        <div class="absolute inset-x-0 top-[-10rem] z-10 transform-gpu overflow-hidden blur-3xl">
            <svg class="relative left-[calc(50%-11rem)] -z-10 h-[21.1875rem] max-w-none -translate-x-1/2 rotate-[30deg] sm:left-[calc(50%-30rem)] sm:h-[42.375rem]" viewBox="0 0 1155 678" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="url(#45de2b6b-92d5-4d68-a6a0-9b9b2abad533)" fill-opacity=".3" d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
                <defs>
                    <linearGradient id="45de2b6b-92d5-4d68-a6a0-9b9b2abad533" x1="1155.49" x2="-78.208" y1=".177" y2="474.645" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#9089FC" offset="0">
                            <animate attributeName="stop-color"
                                     values="red;purple;blue;green;yellow;orange;red;" dur="60s" repeatCount="indefinite">
                            </animate>
                        </stop>
                        <stop offset="1" stop-color="#FF80B5"></stop>
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <div class="relative w-full max-w-md backdrop-blur-lg bg-white/75 px-6 pt-10 pb-8 mb-48 shadow-xl ring-1 ring-gray-900/5 z-20 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10 dark:bg-neutral-800/75">
            <div class="mx-auto">
                <div class="flex items-center">
                    <img src="<?php echo YIPNYAP_URL ?>/img/logo/unicorn-1-min.png" alt="Yipnyap" class="h-8 w-auto" />
                    <h1 class="ml-4 text-2xl font-bold leading-7 text-neutral-700 dark:text-white">
                        <?php if (!empty($missing)) { ?>
                            👋
                        <?php } else { ?>
                            Yipnyap
                        <?php } ?>
                    </h1>
                </div>

                <div class="pt-8 text-base space-y-4 divide-y divide-gray-300/50 text-neutral-500 dark:text-neutral-400">
                    <?php if (!empty($errors)) { ?>
                        <div>
                            <?php foreach ($errors as $error) { ?>
                                <div class="pt-4 text-sm flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-red-500">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-red-500">
                                            <strong class="font-medium">Error:</strong> <?php echo $error ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($warnings)) { ?>
                        <div>
                            <?php foreach ($warnings as $warning) { ?>
                                <div class="pt-4 text-sm flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-yellow-500">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-yellow-500">
                                            <strong class="font-medium">Notice:</strong> <?php echo $warning ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($missing)) { ?>
                        <div class="pb-4 space-y-4">
                            <p>
                                <?php if (!empty(getenv('YIPNYAP_SUPABASE_URL'))) { ?>
                                    Yipnyap has updated and needs more information.
                                <?php } else { ?>
                                    If you're reading this, then congratulations! Yipnyap is ready to be configured.
                                <?php } ?>
                            </p>
                            <p>
                                When asked for a URL of some sort, leave out the protocol unless strictly required.
                                The protocol your webserver is configured as will be used (Prioritised: HTTPS, HTTP).
                                Connections through Cloudflare Flexible SSL are already supported.
                            </p>
                            <p>
                                When using Cloudflare Flexible SSL, <b>and this is a production server, please make
                                    sure to set up an SSL certificate and provide CF with the origin certificate.</b>
                                If this should face real traffic, you should use strict SSL where possible.
                            </p>
                        </div>

                        <form class="pt-8 text-sm space-y-8 divide-y divide-gray-300/50" id="wizard" action="/" method="post">
                            <div class="space-y-4">
                                <!-- "What is the Supabase URL?" input -->
                                <?php if (empty(getenv('YIPNYAP_SUPABASE_URL'))) { ?>
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

                                <?php if (empty(getenv('YIPNYAP_SUPABASE_ANON_KEY'))) { ?>
                                    <div class="flex flex-col">
                                        <label for="supabase_anon_key" class="font-medium text-neutral-900 dark:text-white">
                                            Supabase Anonymous Key
                                        </label>
                                        <input type="text" name="supabase_anon_key" id="supabase_anon_key" required class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                    </div>
                                <?php } ?>

                                <!-- "What is the Supabase key?" input -->
                                <?php if (empty(getenv('YIPNYAP_SUPABASE_SERVICE_KEY'))) { ?>
                                    <div class="flex flex-col">
                                        <label for="supabase_service_key" class="font-medium text-neutral-900 dark:text-white">
                                            Supabase Service Key
                                        </label>
                                        <input type="password" name="supabase_service_key" id="supabase_service_key" required class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                    </div>
                                <?php } ?>

                                <!-- "What is the Logtail source?" input -->
                                <?php if (empty(getenv('YIPNYAP_LOGTAIL_SOURCE_ID'))) { ?>
                                    <div class="flex flex-col">
                                        <label for="logtail_source_id" class="font-medium text-neutral-900 dark:text-white">
                                            Logtail Source ID
                                        </label>
                                        <p class="text-neutral-500 dark:text-neutral-400">
                                            Optional - Logtail is required to view Yipnyap's logs.
                                        </p>
                                        <input type="password" name="logtail_source_id" id="logtail_source_id" class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                    </div>
                                <?php } ?>

                                <?php if (empty(getenv('YIPNYAP_TELEGRAM_BOT_TOKEN'))) { ?>
                                    <div class="flex flex-col">
                                        <label for="telegram_bot_token" class="font-medium text-neutral-900 dark:text-white">
                                            Telegram Bot Token
                                        </label>
                                        <p class="text-neutral-500 dark:text-neutral-400">
                                            Telegram is used to send users notifications and 2-factor authentication codes.
                                            Without this, users will be unable to claim their account.
                                        </p>
                                        <input type="password" name="telegram_bot_token" id="telegram_bot_token" class="mt-1 focus:ring-sky-500 focus:border-sky-500 block w-full border border-gray-300 rounded-md dark:bg-neutral-800 dark:text-white" />
                                    </div>
                                <?php } ?>
                            </div>

                            <?php if (empty(getenv('YIPNYAP_WEBPACK_DEV_SERVER'))) { ?>
                                <div>
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

                                    <div class="pt-8 flex">
                                        <div class="flex items-center h-5">
                                            <input id="setup_as_production" name="setup_as_production" type="checkbox" class="focus:ring-sky-500 h-4 w-4 text-sky-600 border-gray-300 rounded dark:bg-neutral-800 dark:text-white" />
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="setup_as_production" class="font-medium text-neutral-900 dark:text-white">
                                                Treat this Yipnyap install as a production environment.
                                            </label>

                                            <p class="text-neutral-500 dark:text-neutral-400">
                                                This disables most internal debugging and testing features that would normally
                                                be publicly accessible (i.e. Linkbleed). This is recommended for all production
                                                environments and still accessible via localhost.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="pt-8 space-y-4">
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php } else { ?>
                        <?php if (!empty($successes)) { ?>
                            <div>
                                <?php foreach ($successes as $success) { ?>
                                    <div class="pt-4 text-sm flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-green-500">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-green-500">
                                                <?php echo $success ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <!-- Yipnyap is installing notif -->
                        <div class="flex pt-4 items-center space-x-2">
                            <img src="<?php echo YIPNYAP_URL . '/img/symbolic/process-working.symbolic.png' ?>"
                                 alt="Progress spinner" class="w-5 h-5 opacity-75 animate-spin dark:invert"/>

                            <p>
                                Finishing...
                            </p>

                            <script>
                                setTimeout(function () {
                                    window.location.reload();
                                }, 15000);
                            </script>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Dog image peeking on bottom center of screen -->
        <img class="absolute w-48 left-1/2 transform-gpu -translate-x-1/2 bottom-[-6.5rem] [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0.5))]" src="<?php echo YIPNYAP_URL ?>/img/illustrations/settings/shiba-headshot.png" alt="Dog" />

        <div class="absolute inset-x-0 top-[calc(100%-13rem)] z-10 transform-gpu overflow-hidden blur-3xl opacity-50 sm:top-[calc(100%-50rem)]">
            <svg class="relative left-[calc(50%+3rem)] h-[21.1875rem] max-w-none -translate-x-1/2 sm:left-[calc(50%+30rem)] sm:h-[42.375rem]" viewBox="0 0 1155 678" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="url(#45de2b6b-92d5-4d68-a6a0-9b9b2abad533)" fill-opacity=".3" d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
            </svg>
        </div>
    </div>
    </body>
    </html>
<?php die();
