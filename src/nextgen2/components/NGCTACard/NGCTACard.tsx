import React, {SVGProps} from 'react';
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
import {NavLink} from "react-router-dom";

export declare interface NGCtaCardType {
    title: string;
    description: string;
    button?: {
        text: string;
        icon?: ((props: React.SVGProps<SVGSVGElement>) => JSX.Element);
        to: string;
        target?: string;
    }

    theme?: any;
    children?: React.ReactNode;
}

export const NGCtaCardTheming = {
    main: [],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGCTACard({...props}: NGCtaCardType) {
    let theme = buildClassObject(NGCtaCardTheming, props.theme || undefined)

    return (
        <div className="p-8 bg-box rounded-xl highlight-white/5">
            <div className="flex flex-col md:flex-row items-center justify-center">
                <div className="flex flex-col flex-grow md:w-1/2 space-y-2">
                    <h4 className="text-lg">{props.title}</h4>
                    <p className="text-alt-2">
                        {props.description}
                    </p>
                </div>

                {props.button && (
                    <NavLink to={props.button.to} target={props.button.target}>
                        {/* Button CTA */}
                        <button
                            className="w-auto inline-flex p-4 highlight-white/5 rounded-default shadow-sm bg-default text-sm font-medium hover:bg-neutral-50 dark:hover:bg-neutral-700">
                            {props.button.icon &&
                                <props.button.icon className="-ml-1 mr-2 h-5 w-5 text-neutral-400 dark:text-white"/>}
                            <span>{props.button?.text}</span>
                        </button>
                    </NavLink>
                )}
            </div>
        </div>
    );
}
