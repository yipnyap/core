import React, {useEffect, useState} from 'react';

export default function CrawlText({...props}: { children: any; delay?: number; fast?: boolean; }) {
    const [message] = useState(props.children);
    const [delay] = useState(props.delay || 0);
    const [fast] = useState(props.fast || false);
    const [display, setDisplay] = useState(false);
    const [textDOM, setTextDOM] = useState<any[]>([]);

    const LogPrefix = '[🐲 Snapper Engine : 🐞 CrawlText]';
    const Log = (message: string) => {
        console.log(`${LogPrefix} ${message}`);
    }

    if (!message) throw new Error(`${LogPrefix} message is required`);

    const textArray: { currentColour: string; isBold: boolean; i: any; }[] = [];
    let index = 0;

    useEffect(() => {
        Log('Request to re-render needs fulfilment');
        const text = message.split(' ');
        let currentColour = 'default';
        let isBold = false;
        for (const i of text) {
            if (i.startsWith('::')) {
                const command = i.replace('::', '').split(':');
                switch (command[0]) {
                    case 'c': {
                        currentColour = command[1];
                        text[index] = '';
                        break;
                    }

                    case 'bold': {
                        isBold = true;
                        text[index] = '';
                        break;
                    }
                }
            }

            if (text[index].length > 0) {
                textArray.push({
                    currentColour,
                    isBold,
                    i: text[index],
                })
            }

            index++;

            if (index === text.length) {
                setTextDOM(textArray);
                Log('Ready to display');
                setTimeout(() => {
                    setDisplay(true);
                }, delay);
            }
        }
    }, [message])

    return (
        <>
            {textDOM.map((current, index) =>
                <React.Fragment key={index}>
                    {
                        current.i === '::break:' ? <br /> : (
                            <span
                                className={`snapanim-crawl u-rise child-rise${fast ? '-fast' : ''} text-${current.currentColour} ${current.isBold ? 'font-bold' : ''} ${display ? 'risen' : ''} ${current.i.indexOf('<br') > -1 ? 'span-break' : ''}`}
                            >
                                {current.i + ' '}
                            </span>
                        )
                    }
                </React.Fragment>
            )}
        </>
    )
}

export { CrawlText };
