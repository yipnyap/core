import React, {useEffect, useState} from "react";
import {useLocation} from "react-router-dom";
import {useHeading} from "@legacy/providers/PageHeading.provider";
import {RadioGroup} from "@headlessui/react";

const fontSpacings = [
    'Normal',
    'Exa',
    'Giga',
    'Mega',
    'Peta',
    'Tera',
    'Zetta',
];

const fontStyles = [
    'Normal',
    'Mono',
]

let currentMonoFont = localStorage.getItem('monoFont') === 'true';
let currentFontSpacing = parseInt(localStorage.getItem('fontSpacing') || '0');

setMonoFontCSS(currentMonoFont);

function setFontSpacing(font: number) {
    console.log(`Setting font size to ${font}`);
    const yipnyapFontsCSS = document.getElementById('yipnyap-fonts-css');
    if (yipnyapFontsCSS) {
        yipnyapFontsCSS.setAttribute('href', `https://fonts.googleapis.com/css2?family=Lexend${font > 0 ? '+' + fontSpacings[font] : ''}:wght@300..700`)
        document.documentElement.style.setProperty('--font-primary', `'Lexend${font > 0 ? ' ' + fontSpacings[font] : ''}', sans-serif`);
        document.documentElement.style.setProperty('--font-secondary', `'Lexend${font > 0 ? ' ' + fontSpacings[font] : ''}', sans-serif`);
    }
    currentFontSpacing = font;
    currentMonoFont = false;
    localStorage.setItem('fontSpacing', font.toString());
    localStorage.setItem('monoFont', 'false');
}

function setMonoFontCSS(mono: boolean) {
    console.log(`Setting mono font to ${mono}`);
    if (!mono) return setFontSpacing(currentFontSpacing);
    const yipnyapFontsCSS = document.getElementById('yipnyap-fonts-css');
    if (yipnyapFontsCSS) {
        yipnyapFontsCSS.setAttribute('href', `https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700`)
        document.documentElement.style.setProperty('--font-primary', `'Space Grotesk', sans-serif`);
        document.documentElement.style.setProperty('--font-secondary', `'Space Grotesk', sans-serif`);
    }
    currentMonoFont = true;
    localStorage.setItem('monoFont', 'true');
}

function classNames(...classes: string[]) {
    return classes.filter(Boolean).join(' ')
}

export default function SettingsAccessibility({...props}: any) {
    const [heading, setHeading] = useHeading();
    const location = useLocation();
    const [monoFont, setMonoFont] = useState<string | boolean>(localStorage.getItem('monoFont') === 'true' ? 'Mono' : false);
    const [font, setFont] = useState(fontSpacings[currentFontSpacing]);

    useEffect(() => {
        if (heading?.heading !== 'Accessibility') {
            setHeading({
                heading: 'Accessibility',
                padding: true,
                navigator: heading?.navigator,
            })
        }

        if (monoFont === 'Mono') {
            setMonoFontCSS(true);
        } else {
            setMonoFontCSS(false);
            setFontSpacing(fontSpacings.indexOf(font));
        }
    }, [font, monoFont, heading, location.pathname])

    return (
        <>
            {/* Font Spacing */}
            <div className={monoFont === 'Mono' ? 'opacity-25 cursor-not-allowed' : ''}>
                <div className={monoFont === 'Mono' ? 'pointer-events-none' : ''}>
                    <div className="flex items-center justify-between">
                        <h2 className="text-sm font-medium text-default">Font Spacing</h2>
                    </div>

                    <RadioGroup value={font} onChange={setFont} className="mt-2">
                        <RadioGroup.Label className="sr-only">Select a Font Spacing</RadioGroup.Label>
                        <div className="grid grid-cols-3 gap-3 sm:grid-cols-6">
                            {fontSpacings.map((fontSpacing) => (
                                <RadioGroup.Option
                                    key={fontSpacing}
                                    value={fontSpacing}
                                    className={({active, checked}) =>
                                        classNames(
                                            active ? 'ring-2 ring-offset-2 ring-indigo-500' : '',
                                            checked
                                                ? 'bg-box-alt border-transparent text-default hover:bg-box'
                                                : 'bg-box border-default text-default hover:bg-box-alt',
                                            'border border-solid rounded-lg py-3 px-3 flex items-center justify-center text-sm font-medium sm:flex-1'
                                        )
                                    }
                                >
                                    <RadioGroup.Label as="p">{fontSpacing}</RadioGroup.Label>
                                </RadioGroup.Option>
                            ))}
                        </div>
                    </RadioGroup>
                </div>
            </div>

            {/* Font Style */}
            <div>
                <div className="flex items-center justify-between">
                    <h2 className="text-sm font-medium text-default">Font Style</h2>
                </div>

                <RadioGroup value={monoFont} onChange={setMonoFont} className="mt-2">
                    <RadioGroup.Label className="sr-only">Select a Font Style</RadioGroup.Label>
                    <div className="grid grid-cols-3 gap-3 sm:grid-cols-6">
                        {fontStyles.map((fontStyle) => (
                            <RadioGroup.Option
                                key={fontStyle}
                                value={fontStyle}
                                className={({active, checked}) =>
                                    classNames(
                                        active ? 'ring-2 ring-offset-2 ring-indigo-500' : '',
                                        checked
                                            ? 'bg-box-alt border-transparent text-default hover:bg-box'
                                            : 'bg-box border-default text-default hover:bg-box-alt',
                                        'border border-solid rounded-lg py-3 px-3 flex items-center justify-center text-sm font-medium sm:flex-1'
                                    )
                                }
                            >
                                <RadioGroup.Label as="p">{fontStyle}</RadioGroup.Label>
                            </RadioGroup.Option>
                        ))}
                    </div>
                </RadioGroup>
            </div>
        </>
    )
}