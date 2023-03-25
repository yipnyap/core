import {createProgressBar} from '@legacy/utils/plugins';

/**
 * ACHIEVEMENT PROGRESS
 */
createProgressBar({
    container: '.achievement-progress',
    height: 4,
    lineColor: yipnyap_constants.colors['--color-progressbar-underline']
});

createProgressBar({
    container: '.achievement-progress',
    height: 4,
    gradient: {
        colors: [yipnyap_constants.colors['--color-progressbar-line-gradient-start'], yipnyap_constants.colors['--color-progressbar-line-gradient-end']]
    },
    scale: {
        start: 0,
        end: 1,
        stop: 1
    },
    linkText: true,
    linkUnits: '/',
    emptyText: yipnyap_translation.locked,
    completeText: yipnyap_translation['unlocked!']
});

/**
 * ACHIEVEMENT SIMPLE PROGRESS
 */
createProgressBar({
    container: '.achievement-simple-progress',
    height: 4,
    lineColor: yipnyap_constants.colors['--color-progressbar-underline']
});

createProgressBar({
    container: '.achievement-simple-progress',
    height: 4,
    gradient: {
        colors: [yipnyap_constants.colors['--color-progressbar-line-gradient-start'], yipnyap_constants.colors['--color-progressbar-line-gradient-end']]
    },
    scale: {
        start: 0,
        end: 1,
        stop: 1
    }
});

/**
 * RANK PROGRESS
 */
createProgressBar({
    container: '.user-rank-pgb',
    height: 4,
    lineColor: yipnyap_constants.colors['--color-header-progressbar-underline']
});

createProgressBar({
    container: '.user-rank-pgb',
    height: 4,
    gradient: {
        colors: [yipnyap_constants.colors['--color-header-progressbar-line-gradient-start'], yipnyap_constants.colors['--color-header-progressbar-line-gradient-end']]
    },
    scale: {
        start: 0,
        end: 1,
        stop: 1
    },
    linkText: true,
    linkUnits: '/'
});
