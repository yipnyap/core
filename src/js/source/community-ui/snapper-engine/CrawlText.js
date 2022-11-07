import React, {useEffect, useState} from 'react';

function CrawlText(props) {
    const [message] = useState(props.children);
    const [delay] = useState(props.delay || 0);
    const [fast] = useState(props.fast || false);
    const [display, setDisplay] = useState(false);
    const [textDOM, setTextDOM] = useState([]);

    console.log('[Snapper Engine] CrawlText: ', message, index, delay, fast, display, textDOM);

    if (!message) throw new Error('[Snapper Engine] CrawlText: message is required');

    const textArray = [];
    let index = 0;

    useEffect(() => {
        const text = message.split(' ');
        console.log('[Snapper Engine] CrawlText: text: ', text);
        let currentColour = 'primary';
        let isBold = false;
        for (const i of text) {
            if (i.startsWith('::')) {
                const command = i.replace('::', '').split(':');
                switch (command[0]) {
                    case 'c': {
                        console.log(`[Snapper Engine] CrawlText: remove: ${i}, ${index}`);
                        currentColour = command[1];
                        text[index] = '';
                        break;
                    }

                    case 'bold': {
                        console.log(`[Snapper Engine] CrawlText: remove: ${i}, ${index}`);
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
                console.log('[Snapper Engine] CrawlText: textArray: ', textArray);
                setTextDOM(textArray);
                setTimeout(() => {
                    setDisplay(true);
                }, delay);
            }
        }
    }, [message])

    return (
        <>
            {textDOM.map((current, index) =>
                <>
                    {
                        current.i === '::break:' ? <br/> : (
                            <span
                                className={`snapanim-crawl u-rise child-rise${fast ? '-fast' : ''} text-${current.currentColour} ${current.isBold ? 'font-bold' : ''} ${display ? 'risen' : ''} ${current.i.indexOf('<br') > -1 ? 'span-break' : ''}`}
                            >
                                {current.i + ' '}
                            </span>
                        )
                    }
                </>
            )}
        </>
    )
}

export { CrawlText };
