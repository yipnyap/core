import React from 'react';

export declare interface NGBodyType {
    theme?: any;
    children?: React.ReactNode;
    className?: string;
}

export const NGBodyTheming = {
    main: [],
}

export default function NGBody({...props}: NGBodyType) {
    return (
        <div
            className="justify-center m-auto h-full">
            <div
                className={`flex flex-col p-8 pt-10 pb-48 md:px-20 space-y-12 h-full overflow-y-auto overflow-x-hidden ${props.className}`}>
                {props.children}
            </div>

        </div>
    );
}
