<div class="h-full" id="ng2-entrypoint">
    <p class="hidden">
        Oh, uh... Hi there!
        <br />
        If you are reading this, something has gone very wrong. Yipnyap is online, but the UI entrypoint is not working.
        <br />
        Is Javascript enabled on your browser? If so, try <a href="<?php echo YIPNYAP_URL ?>/dist/bundle.js">viewing the bundle</a>
        to see if it is loading correctly. If not, we have a problem on our end.
    </p>

    <div class="flex w-full h-full m-auto">
        <div class="flex flex-col m-auto bg-box rounded-default p-8">
            <div class="flex flex-row justify-center items-center text-default">
                <img src="<?php echo YIPNYAP_URL . '/img/symbolic/process-working.symbolic.png' ?>"
                     alt="Progress spinner" class="w-5 h-5 mr-2 animate-spin dark:invert"/>
                Yipnyap is communicating...
            </div>
        </div>
    </div>
</div>