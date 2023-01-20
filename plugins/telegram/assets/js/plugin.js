/**
 * WP Factor Telegram Plugin
 */
const YipnyapTelegramInteraction = function ($) {

    const $twfci = $("#tg_wp_factor_chat_id");
    const $twfciconf = $("#tg_wp_factor_chat_id_confirm");
    const $twbtn = $("#tg_wp_factor_chat_id_send");
    const $twctrl = $("#tg_wp_factor_valid");

    const $twfcr = $("#factor-chat-response");
    const $twfconf = $("#factor-chat-confirm");
    const $twfcheck = $("#tg_wp_factor_chat_id_check");
    const $twbcheck = $("#checkbot");
    const $twb = $("#bot_token");
    const $twbdesc = $("#bot_token_desc");

    return {
        init: init
    };

    function init() {

        $twfci.on("change", function () {
            $twctrl.val(0);
        });

        $twbtn.on("click", function (evt) {

            evt.preventDefault();
            const chat_id = $twfci.val();
            SendTgToken(chat_id);

        });

        $twfcheck.on("click", function (evt) {

            evt.preventDefault();
            const token = $twfciconf.val();
            check_tg_token(token);

        });

        $twbcheck.on("click", function (evt) {

            evt.preventDefault();
            const bot_token = $twb.val();
            check_tg_bot(bot_token);

        });

    }

    function check_tg_bot(bot_token) {

        $twctrl.val(0);

        $.ajax({

            type: "POST",
            url: ajaxurl,
            data: {
                'nonce': tlj.checkbot_nonce,
                'action': 'CheckBot',
                'bot_token': bot_token
            },
            beforeSend: function () {
                $twbcheck.addClass('disabled').after('<div class="load-spinner"><img src="' + tlj.spinner + '"  alt="Spinner"/></div>');
            },
            dataType: 'json',
            success: function (response) {

                if (response.type === "success") {
                    $twbdesc.html("Bot info: <span class='success'>" + response.args.first_name + " (@" + response.args.username + ")</span>");
                } else {
                    $twbdesc.html("<span class='error'>" + response.msg + "</span>");
                }

            },
            complete: function () {
                $twbcheck.removeClass('disabled');
                $(".load-spinner").remove();
            }

        })

    }

    function check_tg_token(token) {

        $.ajax({

            type: "POST",
            url: ajaxurl,
            data: {
                'action': 'TokenCheck',
                'nonce': tlj.sendtoken_nonce,
                'token': token
            },
            beforeSend: function () {
                $twfcheck.addClass('disabled').after('<div class="load-spinner"><img src="' + tlj.spinner + '"  alt="Spinner"/></div>');
                $twfcr.hide();
            },
            dataType: "json",
            success: function (response) {

                if (response.type === "success") {
                    $twfconf.hide();
                    $twfci.addClass("input-valid");
                    $twctrl.val(1);
                } else {
                    $twfcr.find(".wpft-notice p").text(response.msg);
                    $twfcr.show();
                    $twfci.removeClass("input-valid");
                    $twctrl.val(0);
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                $twfcr.find(".wpft-notice p").text(tlj.ajax_error + " " + thrownError + " (" + xhr.state + ")");
                $twfcr.show();
                $twfci.removeClass("input-valid");
            },
            complete: function () {
                $twfcheck.removeClass('disabled');
                $(".load-spinner").remove();
            }

        });

    }

    function SendTgToken(chat_id) {

        $.ajax({

            type: "POST",
            url: ajaxurl,
            data: {
                'action': 'SendTokenCheck',
                'nonce': tlj.tokencheck_nonce,
                'chat_id': chat_id
            },
            beforeSend: function () {
                $twbtn.addClass('disabled').after('<div class="load-spinner"><img src="' + tlj.spinner + '"  alt="Spinner"/></div>');
                $twfcr.hide();
                $twfconf.hide();
            },
            dataType: "json",
            success: function (response) {

                if (response.type === "success") {
                    $twfconf.show();
                    $twfci.removeClass("input-valid");
                } else {
                    $twfcr.find(".wpft-notice p").text(response.msg);
                    $twfcr.show();
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                $twfcr.find(".wpft-notice p").text(tlj.ajax_error + " " + thrownError + " (" + xhr.state + ")");
                $twfcr.show();
            },
            complete: function () {
                $twbtn.removeClass('disabled');
                $(".load-spinner").remove();
                $twfci.removeClass("input-valid");
            }

        });

    }


}(jQuery);
