/* eslint-disable */
import React from 'react';
import NGNewUserOnboarding from './NGNewUserOnboarding';

export default {
    title: "NGNewUserOnboarding",
    component: NGNewUserOnboarding
};

const Template = (args) => <NGNewUserOnboarding {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

