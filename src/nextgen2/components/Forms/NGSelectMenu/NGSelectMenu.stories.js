/* eslint-disable */
import React from 'react';
import NGSelectMenu from './NGSelectMenu';

export default {
    title: 'NGSelectMenu',
    component: NGSelectMenu,
};

const Template = (args) => <NGSelectMenu {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

