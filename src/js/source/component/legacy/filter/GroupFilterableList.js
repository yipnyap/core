import React from 'react';

import FilterableList from './FilterableList';

import GroupFilterBar from './GroupFilterBar';

import * as groupRouter from '../../../router/group/group-router';

function GroupFilterableList(props) {
  const getItemsFilters = (currentPage) => {
    const itemsFilters = {
      per_page: props.itemsPerPage,
      page: currentPage,
      data_scope: 'group-preview'
    };

    // limit to user groups
    if (props.userID) {
      itemsFilters.user_id = props.userID;
    }

    // limit to search term
    if (props.searchTerm) {
      itemsFilters.search = props.searchTerm;
      // itemsFilters.search_columns = ['name'];
    }

    return itemsFilters;
  };

  const getItemsCountFilters = (filters) => {
    const itemsCountFilters = {
      search: filters.search,
      type: filters.type
    };

    // limit to user groups
    if (props.userID) {
      itemsCountFilters.user_id = props.userID;
    }

    // limit to search term
    if (props.searchTerm) {
      itemsCountFilters.search = props.searchTerm;
      // itemsCountFilters.search_columns = ['name'];
    }

    return itemsCountFilters;
  };

  return(
    <FilterableList itemType='group'
                    gridType={props.gridType}
                    themeColor={props.themeColor}
                    itemsPerPage={props.itemsPerPage}
                    filterBar={GroupFilterBar}
                    getItems={groupRouter.getGroups}
                    getItemsFilters={getItemsFilters}
                    getItemsCount={groupRouter.getGroupsCount}
                    getItemsCountFilters={getItemsCountFilters}
                    searchTerm={props.searchTerm}
                    loggedUserScope='user-groups'
    />
  );
}

export { GroupFilterableList as default };
