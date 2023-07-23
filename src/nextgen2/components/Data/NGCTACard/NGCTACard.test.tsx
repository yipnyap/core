import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGCtaCard from './NGCTACard';

// @ts-ignore
describe('<NGCtaCard />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGCtaCard description="test" title="test"/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
