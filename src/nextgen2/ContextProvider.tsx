import React from 'react';
import {UserContextProvider} from '@legacy/providers/contexts';

interface Props {
    children: React.ReactNode
}

class ContextProvider extends React.Component<Props> {
    constructor(props: Props) {
        super(props);
    }

    render() {
        return (
            <UserContextProvider>
                {this.props.children}
            </UserContextProvider>
        );
    }
}

export default ContextProvider;
