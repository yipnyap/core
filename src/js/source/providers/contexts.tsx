import { createContext, useContext, useState } from 'react';
import type { Dispatch, ReactNode, SetStateAction } from 'react';

export interface User {
    id: string;
    username: string;
    displayName: string;
    pictures?: {
        profile?: {
            version: number,
            url: string,
        },
        header?: {
            version: number,
            url: string,
        },
    }
}

export interface LocalUserContext {
    loggedIn: boolean;
    self?: boolean;
    token: string;
    id: string;
    username?: string;
    displayName?: string;
    pictures?: {
        profile?: {
            version: number,
            url: string,
        },
        header?: {
            version: number,
            url: string,
        },
    }
}

// @ts-ignore
const UserContext = createContext<[LocalUserContext, Dispatch<SetStateAction<LocalUserContext>>]>(null);

function UserContextProvider({ children }: { children: ReactNode }) {
    const [user, useUser] = useState<LocalUserContext>({ loggedIn: false, id: '', token: '', displayName: '', username: '' });

    return <UserContext.Provider value={[user, useUser]}>{children}</UserContext.Provider>;
}

function useUser() {
    const context = useContext(UserContext);
    if (context === undefined) {
        throw new Error('useUser must be used within a <UserContextProvider />');
    }
    return context;
}

export { UserContextProvider, useUser };
