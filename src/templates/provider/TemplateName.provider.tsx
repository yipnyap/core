import {createContext, useContext, useState} from 'react';
import type {Dispatch, ReactNode, SetStateAction} from 'react';

export interface LocalTemplateNameContext {
}

// @ts-ignore
const TemplateNameContext = createContext<[LocalTemplateNameContext, Dispatch<SetStateAction<LocalTemplateNameContext>>]>(null);

function TemplateNameContextProvider({children}: { children: ReactNode }) {
    const [templateName, useTemplateName] = useState<LocalTemplateNameContext>({});

    return <TemplateNameContext.Provider
        value={[templateName, useTemplateName]}>{children}</TemplateNameContext.Provider>;
}

function useTemplateName() {
    const context = useContext(TemplateNameContext);
    if (context === undefined) {
        throw new Error('useTemplateName must be used within a <TemplateNameContextProvider />');
    }

    return context;
}

export {TemplateNameContextProvider, useTemplateName};
