import React from 'react';
import {ThemeContextProvider} from '@nextgen2/providers/Theme.provider';
import NotificationContextProvider from "@nextgen2/providers/Notification.provider";

interface Props {
    children: React.ReactNode
}

class ContextProvider extends React.Component<Props> {
    constructor(props: Props) {
        super(props);
    }

    render() {
        return (
            <NotificationContextProvider>
                <ThemeContextProvider>
                    {this.props.children}
                </ThemeContextProvider>
            </NotificationContextProvider>
        );
    }
}

export default ContextProvider;
