/* eslint-disable */
import React from 'react';
import NGGroupCard from './NGGroupCard';

export default {
    title: "NGGroupCard",
    component: NGGroupCard
};

const Template = (args) => <NGGroupCard {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

