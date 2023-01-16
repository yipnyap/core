import React, {useState, useRef, useEffect} from 'react';

import Loader from '../loader/Loader';

import ItemPreviewList from './ItemPreviewList';

import Pager from '../pager/Pager';

import {deepExtend} from '../../../utils/core';

import * as userRouter from '../../../router/user/user-router';

function FilterableList(props) {
    const [items, setItems] = useState([]);
    const [itemCount, setItemCount] = useState(0);

    const [gridType, setGridType] = useState(props.gridType || 'small');

    const [loadingItems, setLoadingItems] = useState(false);

    const [loggedUser, setLoggedUser] = useState(false);
    const [loadingUser, setLoadingUser] = useState(true);

    const filterableListRef = useRef(null);

    const getLoggedInMember = (callback = () => {
    }) => {
        const getLoggedInMemberScope = props.loggedUserScope ? props.loggedUserScope : 'user-status';

        const getLoggedInMemberPromise = userRouter.getLoggedInMember(getLoggedInMemberScope);

        getLoggedInMemberPromise
            .done((loggedUser) => {
                

                setLoggedUser(loggedUser);
                setLoadingUser(false);

                callback();
            });
    };

    useEffect(() => {
        getLoggedInMember();
    }, []);

    const themeColor = props.themeColor || 'primary';
    const filters = useRef({});

    const currentPage = useRef(1);

    const getItems = () => {
        const config = props.getItemsFilters(currentPage.current);

        deepExtend(config, filters.current);

        

        return props.getItems(config);
    };

    const getItemsCount = (callback) => {
        const config = props.getItemsCountFilters(filters.current);

        

        props.getItemsCount(config, callback);
    };

    const updateItems = () => {
        setLoadingItems(true);

        getItems()
            .done((items) => {
                

                setItems(items);
            })
            .fail((error) => {
                
            })
            .always(() => {
                setLoadingItems(false);
            });
    };

    const updateItemsCount = () => {
        getItemsCount((itemCount) => {
            

            setItemCount(itemCount);
        });
    };

    const applyFilters = (filtersData) => {
        

        // check if filters changed
        let filtersChanged = false;

        for (const filter in filtersData) {
            if (filters.current[filter] !== filtersData[filter]) {
                filtersChanged = true;
                break;
            }
        }

        // if filters didn't change, don't update
        if (!filtersChanged) {
            return;
        }

        deepExtend(filters.current, filtersData);

        // filters changed, update count
        // and reset to first page
        currentPage.current = 1;
        updateItemsCount();
        updateItems();
    };

    const setGrid = (gridType) => {
        setGridType(gridType);

        // only save grid type if there is a user logged in
        if (loggedUser) {
            const updateLoggedUserGridTypePromise = userRouter.updateLoggedUserGridType({
                grid_component: props.itemType,
                grid_type: gridType
            });

            

            updateLoggedUserGridTypePromise
                .done((response) => {
                    
                })
                .fail((error) => {
                    
                });
        }
    };

    const onPageChange = () => {
        

        if (filterableListRef.current) {
            filterableListRef.current.scrollIntoView();
            window.scrollBy({
                top: -120
            });
        }
    };

    const showPage = (pageNumber) => {
        // if page didn't change, don't update items
        if (currentPage.current === pageNumber) {
            return;
        }

        currentPage.current = pageNumber;
        onPageChange();
        updateItems();
    };

    const FilterBar = props.filterBar;

    const itemTypeText = itemCount === 1 ? yipnyap_translation.result : yipnyap_translation.results;

    return (
        <div className="grid gap-2" ref={filterableListRef}>
            <FilterBar extraFilters={props.extraFilters}
                       applyFilters={applyFilters}
                       gridType={gridType}
                       setGrid={setGrid}
                       themeColor={themeColor}
                       searchTerm={props.searchTerm}
            />
            {
                (loadingItems || loadingUser) &&
                <Loader/>
            }
            {
                !(loadingItems || loadingUser) &&
                <React.Fragment>
                    <ItemPreviewList itemType={props.itemType}
                                     gridType={gridType}
                                     data={items}
                                     loggedUser={loggedUser}
                                     onActionComplete={getLoggedInMember}
                    />
                    {
                        itemCount !== 0 &&
                        <React.Fragment>
                            <Pager pageCount={Math.ceil(itemCount / props.itemsPerPage)}
                                   activePage={currentPage.current}
                                   showPage={showPage}
                                   themeColor={themeColor}
                            />
                            <p className="section-results-text">
                                {yipnyap_translation.showing_results_text_1} {currentPage.current === 1 ? 1 : (props.itemsPerPage * (currentPage.current - 1)) + 1} - {(props.itemsPerPage * currentPage.current) > itemCount ? itemCount : props.itemsPerPage * currentPage.current} {yipnyap_translation.showing_results_text_2} {itemCount} {itemTypeText.toLowerCase()}
                            </p>
                        </React.Fragment>
                    }
                </React.Fragment>
            }
        </div>
    );
}

export {FilterableList as default};
