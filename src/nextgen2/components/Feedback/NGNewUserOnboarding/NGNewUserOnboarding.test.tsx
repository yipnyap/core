import React from 'react';
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NGNewUserOnboarding from './NGNewUserOnboarding';

// @ts-ignore
describe('<NGNewUserOnboarding />', () => {
    // @ts-ignore
    test('it should mount', () => {
        render(<NGNewUserOnboarding/>);

        const test = screen.getByTestId('Test');

        // @ts-ignore
        expect(test).toBeInTheDocument();
    });
});
