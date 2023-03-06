/* eslint-disable */
import React from 'react';
import NGSkeleton from './NGSkeleton';

export default {
    title: "NGSkeleton",
    component: NGSkeleton
};

const Template = (args) => <NGSkeleton {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

