import {createContext, useContext, useState} from 'react';
import type { Dispatch, ReactNode, SetStateAction } from 'react';
import {NGContentNavigatorItemType} from "../nextgen/components/NGContentNavigator/NGContentNavigator";

interface PageHeadingContextType {
    heading: string | JSX.Element | null;
    bold?: boolean;
    padding?: boolean;
    slimContentNavigator?: boolean;
    navigator?: {
        subNavigation?: NGContentNavigatorItemType[];
    };
}

const PageHeadingContext = createContext<[PageHeadingContextType | null, Dispatch<SetStateAction<PageHeadingContextType | null>>] | undefined>(undefined);

function PageHeadingProvider({ children }: { children: ReactNode }) {
  const [heading, setHeading] = useState<PageHeadingContextType | null>({
      heading: null,
      bold: false,
      padding: false,
      navigator: {
          subNavigation: []
      },
  });

  return <PageHeadingContext.Provider value={[heading, setHeading]}>{children}</PageHeadingContext.Provider>;
}

function useHeading() {
  const context = useContext(PageHeadingContext);
  if (context === undefined) {
    throw new Error('useHeading must be used within a PageHeadingProvider');
  }
  return context;
}

export { PageHeadingProvider, useHeading };
