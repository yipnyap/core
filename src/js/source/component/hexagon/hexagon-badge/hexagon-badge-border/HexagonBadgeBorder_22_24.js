import React, {useRef, useEffect} from 'react';

import {createHexagon} from '@legacy/utils/plugins';

function HexagonBadgeBorder_22_24(props) {
    const hexagonRef = useRef(null);

    useEffect(() => {
        createHexagon({
            containerElement: hexagonRef.current,
            width: 22,
            height: 24,
            roundedCorners: true,
            roundedCornerRadius: 1,
            fill: true,
            lineColor: yipnyap_constants.colors['--color-box-background']
        });
    }, []);

    return (
        <div className="user-avatar-badge-border">
            <div ref={hexagonRef} className="hexagon-22-24"></div>
        </div>
    );
}

export {HexagonBadgeBorder_22_24 as default};
