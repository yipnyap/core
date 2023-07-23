/* eslint-disable */
import React from 'react';
import NGCommandPalette from './NGCommandPalette';

export default {
    title: 'NGCommandPalette',
    component: NGCommandPalette,
};

const Template = (args) => <NGCommandPalette {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

