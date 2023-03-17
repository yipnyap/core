/* eslint-disable */
import React from 'react';
import NGButton from './NGButton';

export default {
    title: 'NGButton',
    component: NGButton,
};

const Template = (args) => <NGButton {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

