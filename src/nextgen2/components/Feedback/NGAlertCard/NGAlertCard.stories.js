/* eslint-disable */
import React from 'react';
import NGAlertCard from './NGAlertCard';

export default {
    title: "NGAlertCard",
    component: NGAlertCard
};

const Template = (args) => <NGAlertCard {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

