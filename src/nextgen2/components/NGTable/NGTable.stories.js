/* eslint-disable */
import React from 'react';
import NGTable from './NGTable';

export default {
    title: 'NGTable', component: NGTable,
};

const Template = (args) => <NGTable {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

