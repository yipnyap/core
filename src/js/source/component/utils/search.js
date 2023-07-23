import {truncateText} from '@legacy/utils/core';

import postUtils from './post';

const searchStatusTypeData = {
    user: (data) => {
        return [
            data.name,
            `@${data.mention_name}`,
            'friend'
        ];
    },
    group: (data) => {
        const membersText = data.total_member_count === 1 ? yipnyap_translation.member : yipnyap_translation.members;

        return [
            data.name,
            `${data.total_member_count} ${membersText.toLowerCase()}`,
            data.status
        ];
    },
    post: (data) => {
        return [
            truncateText(data.title, 60),
            `${yipnyap_translation.by} ${data.author.name}`,
            postUtils.getPostFormatIcon(data.format)
        ];
    },
    default: () => {
        return ['', '', ''];
    }
};

const getSearchStatusTypeData = (type, data) => {
    return searchStatusTypeData[type] ? searchStatusTypeData[type](data) : searchStatusTypeData.default();
};

export {getSearchStatusTypeData};
