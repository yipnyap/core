// eslint-disable-next-line no-undef
const $ = jQuery; // fuk u wp
$(document).ready(function () {
    const isDarkTheme = $('svg.icon-light-theme')[0];
    const headerBackdrop = 'blur(5px) saturate(0.5)';
    const headerBackgroundOpacity = 90;

    const header = $('#mixheader-timed-greeting');
    const mixbg = $('.bgimg');

    if (isDarkTheme) {
        $('header.header').css({
            'backdrop-filter': headerBackdrop,
            'background-color': `rgb(22 27 40 / ${headerBackgroundOpacity}%)`
        });
    } else {
        $('header.header').css({
            'backdrop-filter': headerBackdrop,
            'background-color': `rgb(248 248 251 / ${headerBackgroundOpacity}%)`
        });
    }

    setInterval(() => {
        const postCommentButton = $('.post-options > .post-option.active');
        if (!postCommentButton) return;
        postCommentButton.remove();
    }, 1000);

    if (header && header.html()) header.html(header.html().replace('Yipnyap is loading', timedGreeting()));
    if (mixbg) mixbg.attr('data-time', timeBG());
});

function timeBG() {
    const today = new Date();
    const curHr = today.getHours();

    if (curHr < 5) {
        return 'night';
    } else if (curHr < 6) {
        return 'day';
    } else if (curHr < 17) {
        return 'day';
    } else if (curHr < 19) {
        return 'sunset';
    } else {
        return 'night';
    }
}

function timedGreeting() {
    const simple = timedGreetingSimple();
    switch (simple) {
        case 'early':
            return '🌆 Sunrise looks great';

        case 'day':
            return '🏙 Good morning';

        case 'afternoon':
            return '🧺 Afternoon';

        case 'sunset':
            return '🌇 Good evening';

        case 'night':
            return '🌃 Good night';
    }
}

function timedGreetingSimple() {
    const today = new Date();
    const curHr = today.getHours();

    if (curHr < 5) {
        return 'night';
    } else if (curHr < 6) {
        return 'early';
    } else if (curHr < 14) {
        return 'day';
    } else if (curHr < 17) {
        return 'afternoon';
    } else if (curHr < 19) {
        return 'sunset';
    } else {
        return 'night';
    }
}
