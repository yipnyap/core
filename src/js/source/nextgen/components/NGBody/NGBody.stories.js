/* eslint-disable */
import React from 'react';
import NGBody from './NGBody';

export default {
    title: "NGBody",
    component: NGBody
};

const Template = (args) => <NGBody {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

