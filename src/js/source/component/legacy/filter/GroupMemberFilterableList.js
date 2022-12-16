import React from 'react';

import FilterableList from './FilterableList';

import GroupMemberFilterBar from './GroupMemberFilterBar';

import * as groupMemberRouter from '../../../router/group-member/group-member-router';

function GroupMemberFilterableList(props) {
  const getItemsFilters = (currentPage) => {
    const itemsFilters = {
      group_id: props.groupID,
      exclude_admins: false,
      per_page: props.itemsPerPage,
      page: currentPage,
      data_scope: 'user-preview'
    };

    // limit to search term
    if (props.searchTerm) {
      itemsFilters.search = props.searchTerm;
    }

    return itemsFilters;
  };

  const getItemsCountFilters = (filters) => {
    const itemsCountFilters = {
      group_id: props.groupID,
      exclude_admins: false,
      search: filters.search,
      status: filters.status
    };

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
                    filterBar={GroupMemberFilterBar}
                    getItems={groupMemberRouter.getGroupMembers}
                    getItemsFilters={getItemsFilters}
                    getItemsCount={groupMemberRouter.getGroupMembersCount}
                    getItemsCountFilters={getItemsCountFilters}
                    searchTerm={props.searchTerm}
                    loggedUserScope='user-friends'
    />
  );
}

export { GroupMemberFilterableList as default };
