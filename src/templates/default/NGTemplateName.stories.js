/* eslint-disable */
import React from 'react';
import NGTemplateName from './NGTemplateName';

export default {
    title: "NGTemplateName",
    component: NGTemplateName
};

const Template = (args) => <NGTemplateName {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

