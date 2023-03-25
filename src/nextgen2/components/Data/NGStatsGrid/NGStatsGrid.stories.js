/* eslint-disable */
import React from 'react';
import NGStatsGrid from './NGStatsGrid';

export default {
    title: 'NGStatsGrid',
    component: NGStatsGrid,
};

const Template = (args) => <NGStatsGrid {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

