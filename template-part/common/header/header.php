<?php
/**
 * Yipnyap Template Part - Community UI Header
 *
 * Displays the header of the community UI
 *
 * @package Yipnyap
 * @since hk14
 * @author Yipnyap (https://yipnyap.xyz/)
 */

$title = $args['title'] ?? '???';
$beta = $args['beta'] ?? false;
$icon = $args['icon'] ?? 'black-question-mark-ornament';
?>

<style>
    html {
        overflow-y: hidden;
    }

    #cmui-entire-content {
        padding: 0 0 80px 80px !important;
        overflow-x: visible !important;
        overflow-y: visible !important;
        transform: translateZ(0);
    }

    @media (max-width: 1024px) {
        #cmui-entire-content {
            padding: 0 0 80px 0 !important;
        }
    }
</style>

<!--<div class="bg-box border-solid border-0 border-b border-divider">-->
    <?php if(isset($args['breadcrumbs'])) { ?>
        <nav class="bg-box border-solid border-0 border-b border-divider flex" aria-label="Breadcrumb">
            <ol role="list" class="max-w-screen-xl w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
                <li class="flex">
                    <div class="flex items-center">
                        <a href="/activity" class="text-alt-2 hover:text-neutral-700">
                            <!-- Heroicon name: solid/home -->
                            <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span class="sr-only">Home</span>
                        </a>
                    </div>
                </li>

                <?php foreach($args['breadcrumbs'] as $item) { ?>
                    <li class="flex">
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 w-6 h-full" style="color:var(--color-border)" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                            </svg>
                            <a href="<?php echo $item['url'] ?>" class="ml-4 text-sm font-medium text-neutral-500 hover:text-neutral-700" aria-current="page"><?php echo $item['title'] ?></a>
                        </div>
                    </li>
                <?php } ?>
            </ol>
        </nav>
    <?php } ?>
    <header class="bg-box sticky top-16 z-20">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="font-bold text-primary items-center flex gap-2">
                <img class="pixelmoji !w-6 !h-6" src="<?php echo YIPNYAP_URL . '/img/emoji/' . $icon . '.gif' ?>" alt="<?php str_replace('-', '', $icon) ?> animated emoji">
                <?php
                echo $title;

                if ($beta) {
                    ?>
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-primary text-white">
                beta
            </span>
                <?php } ?>
            </h1>
        </div>
    </header>
<!--</div>-->
