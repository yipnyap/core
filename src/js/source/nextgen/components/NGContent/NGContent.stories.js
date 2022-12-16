/* eslint-disable */
import React from 'react';
import NGContent from './NGContent';

export default {
    title: "NGContent",
    component: NGContent
};

const Template = (args) => <NGContent {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
    srHeading: 'hello world',
};

