import * as React from 'react';
import Box, { BoxProps } from '@mui/joy/Box';
import {IconButton, Input, Tooltip, Typography, useColorScheme} from "@mui/joy";

import SearchRoundedIcon from '@mui/icons-material/SearchRounded';
import MenuIcon from '@mui/icons-material/Menu';
import DarkModeRoundedIcon from '@mui/icons-material/DarkModeRounded';
import LightModeRoundedIcon from '@mui/icons-material/LightModeRounded';

function ColorSchemeToggle() {
    const { mode, setMode } = useColorScheme();
    const [mounted, setMounted] = React.useState(false);
    React.useEffect(() => {
        setMounted(true);
    }, []);
    if (!mounted) {
        return <IconButton size="sm" variant="outlined" color="primary" />;
    }
    return (
        <Tooltip title="For UI3 Only" variant="soft" placement="left">
            <IconButton
                id="toggle-mode"
                size="sm"
                variant="outlined"
                color="primary"
                onClick={() => {
                    if (mode === 'light') {
                        setMode('dark');
                    } else {
                        setMode('light');
                    }
                }}
            >
                {mode === 'light' ? <DarkModeRoundedIcon /> : <LightModeRoundedIcon />}
            </IconButton>
        </Tooltip>
    );
}

function HeaderBox(props: BoxProps) {
    return (
        <Box
            component="header"
            className="Header"
            {...props}
            sx={[
                {
                    p: 2,
                    gap: 2,
                    bgcolor: 'background.surface',
                    display: 'flex',
                    flexDirection: 'row',
                    justifyContent: 'space-between',
                    alignItems: 'center',
                    gridColumn: '1 / -1',
                    borderBottom: '1px solid',
                    borderColor: 'divider',
                    position: 'sticky',
                    top: 0,
                    zIndex: 1100,
                },
                ...(Array.isArray(props.sx) ? props.sx : [props.sx]),
            ]}
        />
    );
}

export default function Header() {
    return (
        <HeaderBox>
            <Box
                sx={{
                    display: 'flex',
                    flexDirection: 'row',
                    alignItems: 'center',
                    gap: 1.5,
                }}
            >
                <IconButton
                    variant="outlined"
                    size="sm"
                    sx={{ display: { sm: 'none' } }}
                >
                    <MenuIcon />
                </IconButton>
                <IconButton
                    size="sm"
                    variant="solid"
                    sx={{ display: { xs: 'none', sm: 'inline-flex' } }}
                >
                    <img className="h-5" src={yipnyap_constants.logo_url} alt="Yipnyap" />
                </IconButton>
                <Typography component="h1" fontWeight="xl">
                    Yipnyap
                </Typography>
            </Box>
            <Input
                size="sm"
                placeholder="Search anything…"
                startDecorator={<SearchRoundedIcon color="primary" />}
                endDecorator={
                    <IconButton variant="outlined" size="sm" color="neutral">
                        <Typography fontWeight="lg" fontSize="sm" textColor="text.tertiary">
                            /
                        </Typography>
                    </IconButton>
                }
                sx={{
                    flexBasis: '500px',
                    display: {
                        xs: 'none',
                        sm: 'flex',
                    },
                }}
            />
            <Box sx={{ display: 'flex', flexDirection: 'row', gap: 1.5 }}>
                <IconButton
                    size="sm"
                    variant="outlined"
                    color="primary"
                    sx={{ display: { xs: 'inline-flex', sm: 'none' } }}
                >
                    <SearchRoundedIcon />
                </IconButton>

                <ColorSchemeToggle />
            </Box>
        </HeaderBox>
    )
}