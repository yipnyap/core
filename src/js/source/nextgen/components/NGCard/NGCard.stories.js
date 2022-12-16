/* eslint-disable */
import React from 'react';
import NGCard from './NGCard';

export default {
    title: "NGCard",
    component: NGCard
};

const Template = (args) => <NGCard {...args} />;

export const Default = Template.bind({});
Default.args = {
    title: 'Some card',
    wellBody: false,
    children: 'Some content',
};

