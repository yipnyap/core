import React from 'react';
import ReactDOM from 'react-dom';

import Header from '../../../component//header/Header';

const headerElement = document.querySelector('#cmui-header');

if (headerElement) {
    ReactDOM.render(
        <>
            <Header />
            {/*{window.location.hostname === 'yipnyap.local' && (*/}
            {/*<div style={{*/}
            {/*    height: '30px',*/}
            {/*    width: '100vw',*/}
            {/*    color: 'white',*/}
            {/*    padding: '5px',*/}
            {/*    backgroundImage: `repeating-linear-gradient(*/}
            {/*    45deg,*/}
            {/*    #ffb101,*/}
            {/*    #ffb101 0.6em,*/}
            {/*    #212529 0.6em,*/}
            {/*    #212529 1.3em*/}
            {/*    )`*/}
            {/*}}></div>*/}
            {/*)}*/}
        </>,
        headerElement
    );
}
