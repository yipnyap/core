/**
 * @fileoverview All the types for the groups API
 */

export interface Group {
    id: number;
    name: string;
    description?: string;
    avatar?: string;
    banner?: string;
    meta: {
        pivot: {
            current: 'Leader' | 'Administrator' | 'Moderator' | 'Member';
        }; members: {
            count: number; active: number; term: string; data: GroupMember[];
        }
    }
}

export interface GroupMember {
    id: number;
    display_name: string;
    username: string;
    avatar: string;
    header: string;
    followers: number;
    following: number;
    posts: number;
    pivot: {
        current: 'Leader' | 'Administrator' | 'Moderator' | 'Member';
    };
    date_joined: number;
}