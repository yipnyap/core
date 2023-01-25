import {deepMerge} from "../../../../utils/core";

const updateActivityReactions = (activity, newReactions) => {
  const newActivity = deepMerge(activity);

  newActivity.reactions = newReactions;

  return newActivity;
};

const updateActivities = (activities, newActivityData) => {
  // activity data could be from a top level activity
  // or from an activity that is inside a top level activity
  return activities.map((activity) => {
    // found activity to update data of
    if (activity.id === newActivityData.id) {
      return newActivityData;
      // there is media in the current top level activity
    } else if (activity.uploaded_media && (activity.uploaded_media.data.length > 0)) {
      activity.uploaded_media.data = activity.uploaded_media.data.map((uploadedMediaActivity) => {
        // found media activity to update data of
        if (uploadedMediaActivity.id === newActivityData.id) {
          return newActivityData;
        }

        return uploadedMediaActivity;
      });
    }

    return activity;
  });
};

export {
  updateActivityReactions,
  updateActivities
};
