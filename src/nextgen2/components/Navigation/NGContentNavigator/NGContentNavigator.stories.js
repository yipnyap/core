/* eslint-disable */
import React from 'react';
import NGContentNavigator from './NGContentNavigator';
import {HomeIcon as HomeIconSolid} from "@heroicons/react/24/solid";

export default {
    title: "NGContentNavigator",
    component: NGContentNavigator
};

const Template = (args) => <NGContentNavigator {...args} />;

export const Default = Template.bind({});
Default.args = {
    items: [
        {
            name: 'Home Feed',
            description: '',
            href: '#',
            icon: HomeIconSolid,
            current: true,
        },
        {
            name: 'Flood Chat',
            description: 'The coolest place on earth /s',
            href: '#',
            icon: 'https://cdn.discordapp.com/attachments/969997099515142214/1021883380473802823/blue-filled-icon.png',
            current: false,
        },
        {
            name: 'Sick Lads United',
            description: 'yeah',
            href: '#',
            icon: 'https://cdn.discordapp.com/icons/405567817199386624/2c7576010b63ede706bf006d285d77f5.webp?size=96',
            current: false,
        },
    ]
};

