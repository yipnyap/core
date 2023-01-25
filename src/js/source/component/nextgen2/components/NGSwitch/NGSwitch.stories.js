/* eslint-disable */
import React from 'react';
import NGSwitch from './NGSwitch';

export default {
    title: "NGSwitch",
    component: NGSwitch
};

const Template = (args) => <NGSwitch {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

