import React from 'react';

function Loader(props) {
  return (
    <div className={`${props.className} m-auto`}>
        <img className="h-5 w-5 animate-spin dark:invert"
             src={`${yipnyap_constants.yipnyap_url}/img/symbolic/process-working.symbolic.png`}
             alt="Process working spinner"/>
    </div>
  );
}

export { Loader as default };
