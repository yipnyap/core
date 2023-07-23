import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGSelectMenu from './NGSelectMenu';

// @ts-ignore
describe('<NGSelectMenu />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGSelectMenu/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
