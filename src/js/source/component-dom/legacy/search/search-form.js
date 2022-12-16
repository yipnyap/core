import React from 'react';
import ReactDOM from 'react-dom';

import SearchForm from '../../../component/legacy/search/SearchForm';

const searchFormElement = document.querySelector('#vk-search-form');

if (searchFormElement) {
  const userID = Number.parseInt(searchFormElement.getAttribute('data-userid'), 10) || false;

  ReactDOM.render(
    <SearchForm userID={userID} />,
    searchFormElement
  );
}
