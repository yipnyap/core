/* eslint-disable */
import React from 'react';
import NGProfileHeader from './NGProfileHeader';

export default {
    title: "NGProfileHeader",
    component: NGProfileHeader
};

const Template = (args) => <NGProfileHeader {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

