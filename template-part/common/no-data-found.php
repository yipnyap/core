<?php
/**
 * Yipnyap Template Part - No Data Found
 *
 * Displays the no data found message
 *
 * @package Yipnyap
 * @since hk14
 * @author Yipnyap (https://yipnyap.xyz/)
 */

$type = $args['type'] ?? 'data';
?>

<!-- Simple empty state with dashed border -->
<div class="flex flex-col items-center justify-center h-full">
    <div class="flex flex-col items-center justify-center w-full h-full p-8 border-2 border-dashed border-divider rounded-xl">
        <div class="flex items-center justify-center w-12 h-12 mb-4 text-alt">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
            </svg>
        </div>
        <h3 class="mb-2 text-lg font-medium text-primary">No <?php echo $type ?> found</h3>
        <p class="text-sm text-alt">Try searching for something else.</p>
    </div>
</div>
