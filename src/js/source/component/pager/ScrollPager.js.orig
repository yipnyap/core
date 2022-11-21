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
<<<<<<< HEAD
                y: el.offsetTop + el.offsetHeight - (window.innerHeight - 80)
=======
                y: el.offsetTop + el.offsetHeight - document.body.offsetHeight
>>>>>>> 9f2a6e6f03b211d844a74eeab6d79301f410d80e
            },
            windowScrollPosition = {
                y: document.body.scrollTop
            };

        console.log(`[ScrollPager] elementScrollPosition.y: ${elementScrollPosition.y}, windowScrollPosition.y: ${windowScrollPosition.y}`);

        return windowScrollPosition.y > elementScrollPosition.y;
    };

    const loadMoreOnScroll = () => {
<<<<<<< HEAD
        console.log('SCROLL PAGER - LOAD MORE ON SCROLL: ', this.loaderRef.current);

=======
>>>>>>> 9f2a6e6f03b211d844a74eeab6d79301f410d80e
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
