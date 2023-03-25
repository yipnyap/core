import React, {LegacyRef, MouseEventHandler, useEffect, useRef, useState} from 'react';
// @ts-ignore
import {buildClassObject} from '@nextgen2/utils/ColourScheme.utils';

export declare interface NGButtonType {
    onClick?: MouseEventHandler<HTMLButtonElement>;
    variant?: 'lighter' | 'primary' | 'secondary' | 'tertiary' | 'danger' | 'success' | 'warning' | 'info';

    theme?: any;
    children?: React.ReactNode;
    className?: string;
}

export const NGButtonTheming = {
    main: [],
    button: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export const NGButton = React.forwardRef((props: NGButtonType, ref: LegacyRef<HTMLButtonElement> | undefined) => {
    let theme = buildClassObject(NGButtonTheming, props.theme || undefined)
    const buttonRef = useRef(null)

    const [variant, setVariant] = useState<any>({
        useSystemText: true,
    });

    useEffect(() => {
        switch (props.variant) {
            case 'lighter': {
                setVariant({
                    useSystemText: true,
                    dark: {
                        bg: 'dark:bg-neutral-700',
                        hover: 'dark:hover:bg-neutral-800',
                    },
                })

                break;
            }

            case 'danger': {
                setVariant({
                    dark: {
                        bg: 'dark:bg-red-600',
                        hover: 'dark:hover:bg-red-700',
                    },
                    light: {
                        bg: 'bg-red-600',
                        hover: 'hover:bg-red-700',
                    },
                })

                break;
            }
        }
    }, [props.variant]);

    return (
        <button
            type="button"
            className={`${variant.light?.bg || 'bg-white'} ${variant.light?.hover || 'hover:bg-neutral-50'} ${variant.useSystemText ? 'text-default' : 'text-white'} ${variant.dark?.bg || 'dark:bg-neutral-800'} ${variant.dark?.hover || 'dark:hover:bg-neutral-800/75'} w-full inline-flex justify-center rounded-md border border-gray-300 px-4 py-2 text-base font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm`}
            onClick={props.onClick || (
                () => {
                }
            )}
            ref={ref}
        >
            {props.children}
        </button>
    );
});
