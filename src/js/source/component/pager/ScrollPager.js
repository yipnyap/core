import React, {useRef, useEffect} from 'react';

import Loader from '../loader/Loader';

function ScrollPager(props) {
    const loaderRef = useRef(null);

    useEffect(() => {
        if (!props.initialFetch && props.moreItems) {
            document.body.addEventListener('scroll', loadMoreOnScroll);
        }

        return () => {
            document.body.removeEventListener('scroll', loadMoreOnScroll);
        };
    }, [props.initialFetch]);

    const scrolledThrough = (el) => {
        const elementScrollPosition = {
                y: el.offsetTop + el.offsetHeight - document.body.offsetHeight
            },
            windowScrollPosition = {
                y: document.body.scrollTop
            };

        console.log(`[ScrollPager] elementScrollPosition.y: ${elementScrollPosition.y}, windowScrollPosition.y: ${windowScrollPosition.y}`);

        return windowScrollPosition.y > elementScrollPosition.y;
    };

    const loadMoreOnScroll = () => {
        if (scrolledThrough(loaderRef.current)) {
            console.log('[ScrollPager] load more');
            document.body.removeEventListener('scroll', loadMoreOnScroll);
            loadMoreItems();
        }
    };

    const loadMoreItems = () => {
        props.loadMoreItems((moreItems) => {
            if (moreItems) {
                document.body.addEventListener('scroll', loadMoreOnScroll);
            }
        });
    };

    return (
        <div ref={loaderRef} className={`${props.modifiers || ''}`}>
            {props.children}
            {
                props.moreItems &&
                <Loader/>
            }
        </div>
    );
}

export {ScrollPager as default};
