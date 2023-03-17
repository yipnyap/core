import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGStatsGrid from './NGStatsGrid';

// @ts-ignore
describe('<NGStatsGrid />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGStatsGrid/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
