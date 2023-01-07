import React, {useRef, useEffect} from 'react';

import Loader from '../loader/Loader';

function ScrollPager(props) {
    const loaderRef = useRef(null);
    let element;

    useEffect(() => {
        element = (typeof props.element === 'string' ? document.getElementById(props.element) : props.element) || document.body;

        if (!props.initialFetch && props.moreItems) {
            element.addEventListener('scroll', loadMoreOnScroll);
        }

        return () => {
            element.removeEventListener('scroll', loadMoreOnScroll);
        };
    }, [props.initialFetch]);

    const scrolledThrough = (el) => {
        const elementScrollPosition = {
                y: el.offsetTop + el.offsetHeight - element.offsetHeight
            },
            windowScrollPosition = {
                y: element.scrollTop
            };

        if (props.element === 'NGContent') elementScrollPosition.y = elementScrollPosition.y - 84;

        return windowScrollPosition.y > elementScrollPosition.y;
    };

    const loadMoreOnScroll = () => {
        if (scrolledThrough(loaderRef.current)) {
            
            element.removeEventListener('scroll', loadMoreOnScroll);
            loadMoreItems();
        }
    };

    const loadMoreItems = () => {
        props.loadMoreItems((moreItems) => {
            if (moreItems) {
                element.addEventListener('scroll', loadMoreOnScroll);
            }
        });
    };

    return (
        <div ref={loaderRef} className={`${props.modifiers || ''}`}>
            {props.children}
            {
                props.moreItems &&
                <Loader className='pt-4' />
            }
        </div>
    );
}

export {ScrollPager as default};
