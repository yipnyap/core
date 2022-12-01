/* eslint-disable */
import React from 'react';
import NGTabList from './NGTabList';

export default {
    title: "NGTabList",
    component: NGTabList
};

const Template = (args) => <NGTabList {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

