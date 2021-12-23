import React, { useState } from 'react';

import IconSVG from '../../icon/IconSVG';

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
    <div className="action-list-item-wrap" tabIndex="0" onBlur={closeDropdown}>
      {/* DROPDOWN TRIGGER */}
      <div className={`action-list-item ${props.unread ? 'unread' : ''}`} onClick={toggleDropdown}>
        <IconSVG  icon={props.icon}
                  modifiers="action-list-item-icon"
        />
      </div>
      {/* DROPDOWN TRIGGER */}

      {/* DROPDOWN BOX */}
      <div  className="dropdown-box" style={dropdownBoxStyles}>
      { props.children }
      </div>
      {/* DROPDOWN BOX */}
    </div>
  );
}

export { HeaderDropdown as default };