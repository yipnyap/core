/* eslint-disable */
import React from 'react';
import NGSideNav from './NGSideNav';
import {BookmarkIcon, FireIcon, HomeIcon, InboxIcon, UserIcon} from "@heroicons/react/24/outline";

export default {
    title: "NGSideNav",
    component: NGSideNav
};

const Template = (args) => <NGSideNav {...args} />;

export const Default = Template.bind({});
Default.args = {
    items: [
        { name: 'Home', href: '#', icon: HomeIcon },
        { name: 'Trending', href: '#', icon: FireIcon },
        { name: 'Bookmarks', href: '#', icon: BookmarkIcon },
        { name: 'Messages', href: '#', icon: InboxIcon },
        { name: 'Profile', href: '#', icon: UserIcon },
    ]
};

