import React from 'react';
import {ThemeContextProvider} from '@legacy/providers/contexts';

interface Props {
    children: React.ReactNode
}

class ContextProvider extends React.Component<Props> {
    constructor(props: Props) {
        super(props);
    }

    render() {
        return (
            <ThemeContextProvider>
                {this.props.children}
            </ThemeContextProvider>
        );
    }
}

export default ContextProvider;
