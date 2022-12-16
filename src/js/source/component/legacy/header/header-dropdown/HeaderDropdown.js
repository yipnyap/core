import React, { useState } from 'react';

import IconSVG from '../../icon/IconSVG';
import {BellIcon} from "@heroicons/react/24/outline";

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
    <span className="inline-flex" onBlur={closeDropdown}>
      <div className={`ypsdk button-icon -mx-1 p-1 rounded-full text-neutral-400 hover:text-neutral-500 ${props.unread ? 'unread' : ''}`} tabIndex="0" onClick={toggleDropdown}>
        <span className="sr-only">View notifications</span>
        <BellIcon className="h-6 w-6" aria-hidden="true"/>
      </div>

      {/* DROPDOWN BOX */}
      <div className="dropdown-box" style={dropdownBoxStyles}>
      { props.children }
      </div>
      {/* DROPDOWN BOX */}
    </span>
  );
}

export { HeaderDropdown as default };
