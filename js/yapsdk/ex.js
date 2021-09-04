const $ = jQuery; // fuk u wp

/*
 * Moderator Welcome Popup template
 */

const yapexModeratorWelcome = `
<div id="yapex-moderator-welcome-popover" class="yapex card with-lip">
    <h4>hi moderator</h4>
    <p>
        need to ban that <img draggable="false" role="img" class="emoji" alt="✨" src="https://cdn.yipnyap.xyz/bentostack/@rek/emoji-twemoji/svg/2728.svg">
        troglodyte
        <img draggable="false" role="img" class="emoji" alt="✨" src="https://cdn.yipnyap.xyz/bentostack/@rek/emoji-twemoji/svg/2728.svg">? you can do so
        up here, and more, in the Houndboard.
        <br>
        <br>
        please be careful <img draggable="false" role="img" class="emoji" alt="😩" src="https://cdn.yipnyap.xyz/bentostack/@rek/emoji-twemoji/svg/1f629.svg">
        you can do a lot of bad things. (and if you do we'll obliterate your kneecaps)
        <br>
        <br>
        thx bestie xoxo
    </p>
</div>
`

const yapexModeratorWelcomeOverlay = `<div id="yapex-moderator-welcome-popover-overlay" class="yapex overlay"></div>`

$(document).ready(function() {
    const isModerator = $('#wpadminbar')[0]
    const isNewModerator = localStorage.getItem('yapex-mod-pop-viewed')
    const isDarkTheme = $('svg.icon-light-theme')[0]
    const headerBackdrop = 'blur(5px) saturate(0.5)'
    const headerBackgroundOpacity = 90

    if (isDarkTheme) {
        $('header.header').css({
            'backdrop-filter': headerBackdrop,
            'background-color': `rgb(22 27 40 / ${headerBackgroundOpacity}%)`
        })
    } else {
        $('header.header').css({
            'backdrop-filter': headerBackdrop,
            'background-color': `rgb(248 248 251 / ${headerBackgroundOpacity}%)`
        })
    }

    if (isModerator && isNewModerator) {
        $('body').prepend(`<div id="yapex-mod-pop-viewfind">${yapexModeratorWelcome} ${yapexModeratorWelcomeOverlay}</div>`);

        $('body').on('click', '#yapex-moderator-welcome-popover-overlay', () => {
            localStorage.setItem('yapex-mod-pop-viewed', true)
            $('#yapex-mod-pop-viewfind').remove()
        })
    }
});