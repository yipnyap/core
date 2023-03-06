import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGSkeleton from './NGSkeleton';

// @ts-ignore
describe('<NGSkeleton />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGSkeleton/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
