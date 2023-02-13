import React from 'react';

import FilterableList from './FilterableList';

import PostFilterBar from './PostFilterBar';

import * as postRouter from '../../../router/post/post-router';

function PostFilterableList(props) {
  const postTypes = props.postTypes ? props.postTypes.split(',') : ['post'];

  const getItemsFilters = (currentPage) => {
    const itemFilters = {
      numberposts: props.itemsPerPage,
      paged: currentPage,
      post_type: postTypes
    };

    if (props.tag) {
      itemFilters.tag_id = props.tag;
    }

    if (props.user_id) {
      itemFilters.author = props.user_id;
    }

    if (props.year) {
      itemFilters.year = props.year;
    }

    if (props.month) {
      itemFilters.monthnum = props.month;
    }

    if (props.day) {
      itemFilters.day = props.day;
    }

    // limit to search term
    if (props.searchTerm) {
      itemFilters.s = props.searchTerm;
    }

    return itemFilters;
  };

  const getItemsCountFilters = (filters) => {
    const itemFilters = {
      category: filters.category,
      post_type: postTypes
    };

    if (props.tag) {
      itemFilters.tag_id = props.tag;
    }

    if (props.user_id) {
      itemFilters.author = props.user_id;
    }

    if (props.year) {
      itemFilters.year = props.year;
    }

    if (props.month) {
      itemFilters.monthnum = props.month;
    }

    if (props.day) {
      itemFilters.day = props.day;
    }

    // limit to search term
    if (props.searchTerm) {
      itemFilters.s = props.searchTerm;
    }

    return itemFilters;
  };

  return(
    <FilterableList itemType='post'
                    gridType={props.gridType}
                    itemsPerPage={props.itemsPerPage}
                    extraFilters={{category: props.category, postTypes: postTypes}}
                    filterBar={PostFilterBar}
                    getItems={postRouter.getPosts}
                    getItemsFilters={getItemsFilters}
                    getItemsCount={postRouter.getPostCount}
                    getItemsCountFilters={getItemsCountFilters}
    />
  );
}

export { PostFilterableList as default };
