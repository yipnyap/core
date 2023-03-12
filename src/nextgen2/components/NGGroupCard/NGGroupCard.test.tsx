import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGGroupCard from './NGGroupCard';

// @ts-ignore
describe('<NGGroupCard />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGGroupCard group={{}}/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
