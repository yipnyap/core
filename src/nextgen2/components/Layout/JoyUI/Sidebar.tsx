import React from 'react';
import IconButton from '@mui/joy/IconButton';
import List from '@mui/joy/List';
import ListSubheader from '@mui/joy/ListSubheader';
import ListItem from '@mui/joy/ListItem';
import ListItemButton from '@mui/joy/ListItemButton';
import ListItemDecorator from '@mui/joy/ListItemDecorator';
import ListItemContent from '@mui/joy/ListItemContent';

// Icons import
import KeyboardArrowDownRoundedIcon from '@mui/icons-material/KeyboardArrowDownRounded';

import Layout from './Layout';
import {NavLink} from "react-router-dom";

export default function Sidebar({ ...props }: {items: any; subItems: any;}) {
    return (
        <Layout.SideNav>
            <List size="sm" sx={{ '--ListItem-radius': '8px', '--List-gap': '4px' }}>
                <ListItem nested>
                    <ListSubheader>
                        Browse
                        <IconButton
                            className="w-auto ml-auto"
                            size="sm"
                            variant="plain"
                            color="primary"
                            sx={{ '--IconButton-size': '24px' }}
                        >
                            <KeyboardArrowDownRoundedIcon fontSize="small" color="primary" />
                        </IconButton>
                    </ListSubheader>
                    <List
                        aria-labelledby="nav-list-browse"
                        sx={{
                            '& .JoyListItemButton-root': { p: '8px' },
                        }}
                    >
                        {props.items?.map((item: any) => (
                            <ListItem key={item.name}>
                                <NavLink to={item.href}>
                                    <ListItemButton>
                                        <ListItemDecorator>
                                            {typeof item.icon === 'string' ? (
                                                <img className="w-5 h-5" src={item.icon} alt={item.name} />
                                            ) : (
                                                <item.icon className="w-5 h-5" />
                                            )}
                                        </ListItemDecorator>
                                        <ListItemContent>
                                            {item.name}
                                        </ListItemContent>
                                    </ListItemButton>
                                </NavLink>
                            </ListItem>
                        ))}
                    </List>
                </ListItem>
                <ListItem nested className="mt-2">
                    <ListSubheader>
                        Page Context
                        <IconButton
                            className="w-auto ml-auto"
                            size="sm"
                            variant="plain"
                            color="primary"
                            sx={{ '--IconButton-size': '24px' }}
                        >
                            <KeyboardArrowDownRoundedIcon fontSize="small" color="primary" />
                        </IconButton>
                    </ListSubheader>
                    <List
                        aria-labelledby="nav-list-browse"
                        sx={{
                            '& .JoyListItemButton-root': { p: '8px' },
                        }}
                    >
                        {props.subItems?.map((item: any) => (
                            <ListItem key={item.name}>
                                <NavLink to={item.href}>
                                    <ListItemButton>
                                        <ListItemDecorator>
                                            {typeof item.icon === 'string' ? (
                                                <img className="w-5 h-5" src={item.icon} alt={item.name} />
                                            ) : (
                                                <item.icon className="w-5 h-5" />
                                            )}
                                        </ListItemDecorator>
                                        <ListItemContent>
                                            {item.name}
                                        </ListItemContent>
                                    </ListItemButton>
                                </NavLink>
                            </ListItem>
                        ))}
                    </List>
                </ListItem>
            </List>
        </Layout.SideNav>
    );
}
