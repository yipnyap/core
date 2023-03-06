export const dateDifference = (date1: Date | number, date2: Date | number = new Date()) => {
    // Check if date1 and date2 are numbers, if not, convert them to numbers
    date1 = typeof date1 === 'number' ? date1 : new Date(date1).getTime();
    date2 = typeof date2 === 'number' ? date2 : new Date(date2).getTime();

    const timeDiff = Math.abs(date1 - date2);
    const secondsDiff = Math.ceil(timeDiff / (1000));
    const minutesDiff = Math.floor(timeDiff / (1000 * 60));
    const hoursDiff = Math.floor(timeDiff / (1000 * 60 * 60));
    const daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
    const weeksDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24 * 7));
    const monthsDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24 * 7 * 4));
    const yearsDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24 * 7 * 4 * 12));

    let unit;

    if (secondsDiff < 60) {
        unit = secondsDiff === 1 ? 'second' : 'seconds';

        return {
            unit: unit,
            value: secondsDiff
        };
    } else if (minutesDiff < 60) {
        unit = minutesDiff === 1 ? 'minute' : 'minutes';

        return {
            unit: unit,
            value: minutesDiff
        };
    } else if (hoursDiff < 24) {
        unit = hoursDiff === 1 ? 'hour' : 'hours';

        return {
            unit: unit,
            value: hoursDiff
        };
    } else if (daysDiff < 7) {
        unit = daysDiff === 1 ? 'day' : 'days';

        return {
            unit: unit,
            value: daysDiff
        };
    } else if (weeksDiff < 4) {
        unit = weeksDiff === 1 ? 'week' : 'weeks';

        return {
            unit: unit,
            value: weeksDiff
        };
    } else if (monthsDiff < 12) {
        unit = monthsDiff === 1 ? 'month' : 'months';

        return {
            unit: unit,
            value: monthsDiff
        };
    } else {
        unit = yearsDiff === 1 ? 'year' : 'years';

        return {
            unit: unit,
            value: yearsDiff
        };
    }
};