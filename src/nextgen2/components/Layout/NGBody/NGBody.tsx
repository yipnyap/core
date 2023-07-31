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
            id="NGBody"
            className="justify-center m-auto px-8 pt-10 pb-48 md:px-20 overflow-hidden">
            <div
                className={`flex flex-col max-w-4xl mx-auto space-y-12 ${props.className}`}>
                {props.children}
            </div>
        </div>
    );
}
