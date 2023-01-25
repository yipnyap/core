import React from 'react';

import gridUtils from '../utils/grid';

import Notification from '../notification/Notification';

function ItemPreviewList(props) {
    let grid;

    // if there are items, show them
    if (props.data.length) {
        const GridTemplate = gridUtils.getGridTemplate(props.itemType, props.gridType);

        const items = props.data.map((item) => {
            const ItemPreviewTemplate = gridUtils.getItemPreviewTemplate(props.itemType, props.gridType, item);

            return (
                <ItemPreviewTemplate key={item.id}
                                     data={item}
                                     loggedUser={props.loggedUser}
                                     onActionComplete={props.onActionComplete}
                />
            );
        });

        grid = <GridTemplate content={items}/>;
    } else {
        // no items, show message
        grid = <Notification title={yipnyap_translation.no_results_found}
                             text={yipnyap_translation.item_list_no_results_text}
        />;
    }

    return grid;
}

export {ItemPreviewList as default};
