import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGButton from './NGButton';

// @ts-ignore
describe('<NGButton />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGButton/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
