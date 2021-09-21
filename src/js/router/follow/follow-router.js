/**
 * General
 */
const addFollow = (config) => {
  const data = {
    action: 'vikinger_follow_add_ajax',
    args: config,
    _ajax_nonce: vikinger_constants.vikinger_ajax_nonce
  };

  return jQuery.post(vikinger_constants.ajax_url, data);
};

const removeFollow = (config) => {
  const data = {
    action: 'vikinger_follow_remove_ajax',
    args: config,
    _ajax_nonce: vikinger_constants.vikinger_ajax_nonce
  };

  return jQuery.post(vikinger_constants.ajax_url, data);
};

export {
  addFollow,
  removeFollow,
};