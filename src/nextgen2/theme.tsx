import { extendTheme } from '@mui/joy/styles';

export default extendTheme({
    colorSchemes: {
        light: {
            palette: {
                background: {
                    body: '#fafafa',
                },
            },
        },
        dark: {
            palette: {
                background: {
                    body: 'var(--joy-palette-common-black)',
                    surface: '#1b1b1c',
                },
            },
        },
    },
    fontFamily: {
        // display: "'Inter', var(--joy-fontFamily-fallback)",
        // body: "'Inter', var(--joy-fontFamily-fallback)",
    },
});
