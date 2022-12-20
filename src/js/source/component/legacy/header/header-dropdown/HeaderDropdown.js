import React, { useState } from 'react';

import {BellIcon} from "@heroicons/react/24/outline";
import {BeakerIcon} from "@heroicons/react/24/solid";

function HeaderDropdown(props) {
  const [dropdownIsOpen, setDropdownIsOpen] = useState(false);

  const toggleDropdown = () => {
    setDropdownIsOpen(previousDropdownIsOpen => {
      return !previousDropdownIsOpen;
    });
  };

  const closeDropdown = () => {
    setDropdownIsOpen(false);
  };

  const openDropdown = () => {
    setDropdownIsOpen(true);
  };

  const dropdownBoxStyles = {
    position: 'absolute',
    top: '64px',
    right: '6px',
    transition: 'transform 0.25s cubic-bezier(0,1.25,0,1)',
    opacity: dropdownIsOpen ? 1 : 0,
    visibility: dropdownIsOpen ? 'visible' : 'hidden',
    transform: dropdownIsOpen ? 'translate(0, 0)' : 'translate(0, 2rem)'
  };

  return (
    <span className="inline-flex">
      <div className={`ypsdk button-icon -mx-1 p-1 rounded-full text-neutral-400 hover:text-neutral-500 ${props.unread ? 'unread' : ''}`} tabIndex="0" onClick={toggleDropdown} onMouseEnter={openDropdown}>
        <span className="sr-only">View notifications</span>
        <BellIcon className="h-6 w-6" aria-hidden="true"/>
      </div>

      {/* DROPDOWN BOX */}
      <div className="dropdown-box" style={dropdownBoxStyles} onMouseLeave={closeDropdown}>
      {/* Update notice card */}
        <div className="flex p-6 bg-box-alt rounded-xl">
            <div className="flex-shrink-0">
              <BeakerIcon className="h-5 w-5 text-default" aria-hidden="true"/>
            </div>
            <div className="ml-3">
                <p className="text-sm font-medium text-default">
                    How you view notifications is changing
                </p>
                <p className="mt-1 text-sm text-alt-2">
                  Your notifications will soon be moving to it's own tab in your profile, and on the sidebar.
                  You can still access them here for now.
                  <br /><br />
                  Notifications via Discord DMs or Webhooks will also be coming soon! <a href="https://discord.gg/wrCGpAB" className="text-default underline" target="_blank">Join our Discord server</a> to stay up to date.
                </p>
            </div>
        </div>
      { props.children }
      </div>
      {/* DROPDOWN BOX */}
    </span>
  );
}

export { HeaderDropdown as default };
