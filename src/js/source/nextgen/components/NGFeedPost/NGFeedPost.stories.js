/* eslint-disable */
import React from 'react';
import NGFeedPost from './NGFeedPost';

export default {
    title: "NGFeedPost",
    component: NGFeedPost
};

const Template = (args) => <NGFeedPost {...args} />;

export const Default = Template.bind({});
Default.args = {
    post: {
        id: '2',
        likes: '29',
        author: {
            name: 'Rek',
            imageUrl:
                'https://yipnyap.xyz/vault/@server/uploads/members/1/avatars//1660767122-bpfull.png',
            username: 'rek',
        },
        date: '~1h ago',
        datetime: '2020-12-09T11:43:00',
        body: <>
            <p>I put deodorant</p>
        </>,
        replies: [{
            id: '3',
            likes: '29',
            author: {
                name: 'Fludd',
                imageUrl:
                    'https://cdn.discordapp.com/avatars/192084188588015626/578490aa6516a6beec2ba7db189a1a47.webp?size=80',
                username: 'flooderino',
            },
            date: '~1h ago',
            datetime: '2020-12-09T11:43:00',
            body: <>
                <p>on my balls</p>
            </>,
        }]
    },
};

