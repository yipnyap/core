import {createContext, useContext, useState} from 'react';
import type {Dispatch, ReactNode, SetStateAction} from 'react';

export interface LocalThemeContext {
    variant: string;
    accent: string;
    background?: string;
}

// @ts-ignore
const ThemeContext = createContext<[LocalThemeContext, Dispatch<SetStateAction<LocalThemeContext>>]>(null);

function ThemeContextProvider({children}: { children: ReactNode }) {
    const [theme, useTheme] = useState<LocalThemeContext>({
        variant: localStorage.getItem('theme')?.toLowerCase() || 'system',
        accent: yipnyap_constants.currentUser?.dipswitch?.accent?.toLowerCase() || 'blue',
    });

    console.log('[🌇 Theme] Initial: ', theme);
    return <ThemeContext.Provider value={[theme, useTheme]}>{children}</ThemeContext.Provider>;
}

function useTheme() {
    const context = useContext(ThemeContext);
    if (context === undefined) {
        throw new Error('useTheme must be used within a <ThemeContextProvider />');
    }

    console.log('[🌇 Theme] Context pulled');
    return context;
}

export {ThemeContextProvider, useTheme};
