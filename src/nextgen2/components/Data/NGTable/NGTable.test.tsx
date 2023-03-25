import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGTable from './NGTable';

// @ts-ignore
describe('<NGTable />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGTable/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
