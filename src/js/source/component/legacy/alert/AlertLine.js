import React from 'react';

import IconSVG from '../icon/IconSVG';

function AlertLine(props) {
  return (
    <div className={`alert-line alert-line-${props.type} ${props.margin === 'b' ? 'mb-4' : ''}`}>
      <IconSVG  icon={props.type}
                modifiers="alert-line-icon"
      />
      <p className="alert-line-text"><span className="bold">{props.title}</span><br /> {props.text}</p>
    </div>
  );
}

export { AlertLine as default };
