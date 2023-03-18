/* eslint-disable */
import React from 'react';
import NGNavbar from './NGNavbar';

export default {
    title: 'NGNavbar',
    component: NGNavbar,
};

const Template = (args) => <NGNavbar {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

