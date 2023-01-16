import React from 'react';

import FilterableList from './FilterableList';

import MemberFilterBar from './MemberFilterBar';

import * as memberRouter from '../../../router/member/member-router';

function MemberFilterableList(props) {
  const getItemsFilters = (currentPage) => {
    const itemsFilters = {
      per_page: props.itemsPerPage,
      page: currentPage,
      data_scope: 'user-preview'
    };

    // limit to members friends of user
    if (props.userID) {
      itemsFilters.user_id = props.userID;
    }

    // limit to members of a group
    if (props.groupID) {
      itemsFilters.group_id = props.groupID;
    }

    // limit to search term
    if (props.searchTerm) {
      itemsFilters.search = props.searchTerm;
    }

    return itemsFilters;
  };

  const getItemsCountFilters = (filters) => {
    const itemsCountFilters = {
      search: filters.search,
      type: filters.type
    };

    // limit to members friends of user
    if (props.userID) {
      itemsCountFilters.user_id = props.userID;
    }

    // limit to members of a group
    if (props.groupID) {
      itemsCountFilters.group_id = props.groupID;
    }

    // limit to search term
    if (props.searchTerm) {
      itemsCountFilters.search = props.searchTerm;
    }

    return itemsCountFilters;
  };

  return(
    <FilterableList itemType='member'
                    gridType={props.gridType}
                    themeColor={props.themeColor}
                    itemsPerPage={props.itemsPerPage}
                    filterBar={MemberFilterBar}
                    getItems={memberRouter.getMembers}
                    getItemsFilters={getItemsFilters}
                    getItemsCount={memberRouter.getMembersCount}
                    getItemsCountFilters={getItemsCountFilters}
                    searchTerm={props.searchTerm}
                    loggedUserScope='user-friends'
    />
  );
}

export { MemberFilterableList as default };
