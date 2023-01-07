import {querySelector} from '../utils/core';

querySelector('.vk-form-counter-input', (els) => {
    for (const counter of els) {
        const parent = counter.parentElement,
            counterIncreaseControl = parent.querySelector('.vk-form-counter-control-increase'),
            counterDecreaseControl = parent.querySelector('.vk-form-counter-control-decrease');

        if (counterIncreaseControl) {
            counterIncreaseControl.addEventListener('mousedown', () => {
                counter.stepUp();
            });
        }

        if (counterDecreaseControl) {
            counterDecreaseControl.addEventListener('mousedown', () => {
                counter.stepDown();
            });
        }
    }
});
