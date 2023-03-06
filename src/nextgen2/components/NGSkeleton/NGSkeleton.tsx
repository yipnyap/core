import React, {useEffect, useState} from 'react';
import {buildClassObject} from "@nextgen2/utils/ColourScheme.utils";
// @ts-ignore
import styles from './NGSkeleton.module.scss';

export declare interface NGSkeletonType {
    theme?: any;
    children?: React.ReactNode;
}

export const NGSkeletonTheming = {
    main: [styles.item, 'dark:bg-neutral-800/50'],
}

function classNames(...classes: any[]) {
    return classes.filter(Boolean).join(' ')
}

export default function NGSkeleton({...props}: NGSkeletonType) {
    let theme = buildClassObject(NGSkeletonTheming, props.theme || undefined)
    const [classes, setClasses] = useState(styles.itemIn);

    useEffect(() => {
        const interval = setInterval(() => {
            setClasses(styles.itemOut);
            setTimeout(() => {
                setClasses(styles.itemIn);
            }, 500);
        }, 1000);

        return () => clearInterval(interval);
    });

    return (
        <div className="space-y-6">
            <div className={`h-32 ${theme.main} ${classes}`}></div>
            <div className={`h-48 ${theme.main} ${classes}`}></div>
            <div className={`h-40 ${theme.main} ${classes}`}></div>
        </div>
    );
}
