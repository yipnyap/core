import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGCommandPalette from './NGCommandPalette';

// @ts-ignore
describe('<NGCommandPalette />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGCommandPalette/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
