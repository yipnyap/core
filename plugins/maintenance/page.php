<?php
$protocol = $_SERVER['SERVER_PROTOCOL'];
if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol) {
    $protocol = 'HTTP/1.0';
}

header("$protocol 503 Service Unavailable", true, 503);
header('Content-Type: text/html; charset=utf-8');
?>
<html lang="en" class="antialiased">
<head>
    <title>Yipnyap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        img[alt="bg"] {
            filter: hue-rotate(0);
            animation: hue 60s linear infinite;
        }

        @keyframes hue {
            0% {
                filter: hue-rotate(0);
            }

            100% {
                filter: hue-rotate(360deg);
            }
        }

    </style>
</head>
<body class="bg-gray-50 dark:bg-neutral-900">
<div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 dark:bg-neutral-900 py-6 sm:py-12">
    <img src="<?php echo YIPNYAP_URL ?>/img/background/generic-generated.png" alt="bg" class="absolute w-full h-full opacity-25" />
    <div class="absolute z-10 inset-0 bg-[url(<?php echo YIPNYAP_URL ?>/img/background/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
    <div class="relative backdrop-blur-lg bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 z-20 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10 dark:bg-neutral-800/75">
        <div class="mx-auto max-w-md">
            <div class="flex items-center">
                <img src="<?php echo YIPNYAP_URL ?>/img/logo/unicorn-1-min.png" alt="Yipnyap" class="h-8 w-auto" />
                <h1 class="ml-4 text-2xl font-bold leading-7 text-neutral-700 dark:text-white">
                    Yipnyap
                </h1>
            </div>

            <div class="divide-y divide-gray-300/50">
                <div class="py-8 text-base leading-6 space-y-4 text-neutral-700 dark:text-white sm:text-lg sm:leading-7">
                    <p>
                        We are currently performing maintenance on the core of our platform. Please check back later.
                    </p>
                </div>

                <div class="pt-8 text-base font-semibold leading-7">
                    <p class="text-neutral-700 dark:text-white">
                        This is not an error, please do not report it as such.
                    </p>
                    <p class="flex flex-col">
                        <a href="https://discord.gg/wrCGpAB" class="text-sky-500 hover:text-sky-600">Discord &rarr;</a>
                        <a href="https://twitter.com/wychefur" class="text-sky-500 hover:text-sky-600">Twitter (Not Recommended) &rarr;</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php die();
