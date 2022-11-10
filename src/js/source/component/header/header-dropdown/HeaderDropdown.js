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
    transition: 'transform .4s ease-in-out, opacity .4s ease-in-out, visibility .4s ease-in-out',
    opacity: dropdownIsOpen ? 1 : 0,
    visibility: dropdownIsOpen ? 'visible' : 'hidden',
    transform: dropdownIsOpen ? 'translate(0, 0)' : 'translate(0, -40px)'
  };

  return (
    <span className="inline-flex" onBlur={closeDropdown}>
      <div className={`ypsdk button-icon -mx-1 p-1 rounded-full text-gray-400 hover:text-gray-500 ${props.unread ? 'unread' : ''}`} tabIndex="0" onClick={toggleDropdown}>
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
