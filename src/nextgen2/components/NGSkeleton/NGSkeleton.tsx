import React, {useEffect, useState} from 'react';
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
// @ts-ignore
import styles from './NGSkeleton.module.scss';
import {useLocation} from "react-router-dom";

export declare interface NGSkeletonType {
    theme?: any;
    children?: React.ReactNode;
}

export const NGSkeletonTheming = {
    main: [styles.item, 'p-8', 'dark:bg-neutral-800/50'],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGSkeleton({...props}: NGSkeletonType) {
    let theme = buildClassObject(NGSkeletonTheming, props.theme || undefined)
    const [classes, setClasses] = useState(styles.itemIn);
    const [loopCount, setLoopCount] = useState(1);
    const location = useLocation();

    useEffect(() => {
        let i = 1;
        const animation = () => {
            setClasses(styles.itemOut);
            setTimeout(() => {
                setClasses(styles.itemIn);

                if (i === 5) {
                    setLoopCount(1);
                    i = 1;
                } else {
                    setLoopCount(i + 1);
                    i++;
                }
            }, 500);
        };

        animation();
        const interval = setInterval(animation, 1000);

        return () => clearInterval(interval);
    }, [location.pathname]);

    return (
        <div className="space-y-6">
            <div className={`h-32 ${theme.main} ${classes}`}></div>
            <div className={`h-48 ${theme.main} ${classes}`}>
                {loopCount === 5 && (
                    <div className="relative space-y-4">
                        <img src={`${yipnyap_constants.yipnyap_url}/img/illustrations/onboarding/gray-cat.png`}
                             alt="Gray Cat" className="h-32 w-auto"/>
                    </div>
                )}
            </div>
            <div className={`h-40 ${theme.main} ${classes}`}></div>
        </div>
    );
}
