import {deepExtend} from '@legacy/utils/core';

const Paginator = {
  getNextPageToFetch: function (options) {
    const config = {
      createCount: 0,
      deleteCount: 0
    };

    deepExtend(config, options);

    let pageOffset = 0,
        countDiff = config.createCount - config.deleteCount;

    if (countDiff === 0) {
      return config.page;
    }

    if (countDiff > 0) {
      pageOffset = Math.floor(Math.abs(countDiff) / config.per_page);
    } else {
      pageOffset = -Math.ceil(Math.abs(countDiff) / config.per_page);
    }

    return config.page + pageOffset;
  },
  removeDuplicates: function (items, newItems, compareKey) {
    const duplicateItemKeys = [];

    for (const item of items) {
      for (const newItem of newItems) {
        // if duplicate found
        if (item[compareKey] === newItem[compareKey]) {
          duplicateItemKeys.push(item[compareKey]);
          break;
        }
      }
    }

    // if any duplicates were found
    if (duplicateItemKeys.length > 0) {
      return newItems.filter((item) => {
        return !(duplicateItemKeys.includes(item[compareKey]));
      });
    }

    return newItems;
  }
};

export { Paginator as default };
