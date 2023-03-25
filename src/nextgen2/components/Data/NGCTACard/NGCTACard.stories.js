/* eslint-disable */
import React from 'react';
import NGCtaCard from './NGCTACard';

export default {
    title: 'NGCtaCard',
    component: NGCtaCard,
};

const Template = (args) => <NGCtaCard {...args} />;

export const Default = Template.bind({});
Default.args = {
    children: 'hello world',
};

