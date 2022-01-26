import React from 'react';

function BadgeItemMore(props) {
    return (
        <a className="badge-item badge-item-more" href={props.more_link}>
            <img src={`${yipnyap_constants.yipnyap_url}/img/badge/blank-s.png`} alt="badge-blank-s"/>
            <p className="badge-item-text">+{props.more_count}</p>
        </a>
    );
}

export {BadgeItemMore as default};
