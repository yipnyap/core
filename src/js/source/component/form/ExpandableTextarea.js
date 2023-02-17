import React, {useEffect, useLayoutEffect, useRef, useState} from 'react';

import MentionList from '../mention/MentionList';

import LoaderSpinner from '../loader/LoaderSpinner';

import {getPositionInInput, getWordInPosition, insertWordInText, updateShadowInput} from '@legacy/utils/core';
import {createFormInput} from '@legacy/utils/plugins';

function ExpandableTextarea(props) {
    const [mentioning, setMentioning] = useState(false);
    const [mentionChars, setMentionChars] = useState('');
    const [mentionPositionData, setMentionPositionData] = useState(false);

    const maxLength = useRef(props.maxLength || 1000);
    const minHeight = useRef(props.minHeight || 48);

    const formTextareaRef = useRef(null);
    const textareaRef = useRef(null);
    const shadowTextareaRef = useRef(null);

    const mounting = useRef(true);

    const wordInCursor = useRef({});

    const pressedKeys = useRef({});

    const savePressedKey = (e) => {
        pressedKeys.current[e.keyCode] = true;
    };

    const resetPressedKey = (e) => {
        pressedKeys.current[e.keyCode] = false;
    };

    const resetPressedKeys = () => {
        pressedKeys.current = {};
    };

    const clearInput = () => {
        formTextareaRef.current.classList.remove('active');
    };

    const updateTextareaDimensions = () => {
        // set minimum textarea height
        textareaRef.current.style.height = `${minHeight.current}px`;

        const scrollHeight = textareaRef.current.scrollHeight;

        // if scroll height is greater that minimum height, set it as textarea height
        if (scrollHeight > minHeight.current) {
            textareaRef.current.style.height = `${textareaRef.current.scrollHeight}px`;
        }
    };

    const submitOnEnterKeyPress = () => {
        const shift = 16,
            enter = 13;

        // enter key
        if (pressedKeys.current[enter] && !pressedKeys.current[shift]) {
            resetPressedKeys();
            props.onSubmit();
        }
    };

    const addNewlineOnShiftEnterKeyPress = () => {
        const shift = 16,
            enter = 13;

        // shift + enter
        if (pressedKeys.current[shift] && pressedKeys.current[enter]) {
            // put newline in textarea
            props.handleChange({
                target: {
                    name: props.name,
                    value: props.value + '\n'
                }
            });
        }
    };

    const disableEnterKey = (e) => {
        const enter = 13;

        if (e.keyCode === enter) {
            e.preventDefault();
        }
    };

    const disableInputArrows = (e) => {
        // arrow up/down pressed
        if ((e.keyCode === 38) || (e.keyCode === 40)) {
            e.preventDefault();
        }
    };

    const oneTimeDisableInput = (e) => {
        // spacebar or enter key pressed
        if ((e.keyCode === 32) || (e.keyCode === 13)) {
            e.preventDefault();
            textareaRef.current.removeEventListener('keydown', oneTimeDisableInput);
        }
    };

    const getTextWithMention = (mentionText) => {
        return insertWordInText(textareaRef.current.value, `@${mentionText}`, wordInCursor.current.startIndex, wordInCursor.current.word.length);
    };

    const closeMention = (mentionData, event) => {
        setMentioning(false);

        // don't interrupt writing focus
        textareaRef.current.focus();

        // set cursor position to be after user mention
        if (mentionData) {
            textareaRef.current.selectionEnd = wordInCursor.current.startIndex + mentionData.length + 1;
        }

        // enable arrows
        textareaRef.current.removeEventListener('keydown', disableInputArrows);

        // if event is not keydown (user didn't press spacebar/enter to select mention), remove enter/spacebar block
        if (event !== 'keydown') {
            textareaRef.current.removeEventListener('keydown', oneTimeDisableInput);
        }
    };

    const checkForMentions = (text) => {
        // get word in current cursor position
        const currentCursorPosition = textareaRef.current.selectionStart,
            currentWordInCursor = getWordInPosition(text, currentCursorPosition);

        // if word has @, user is trying to mention
        const mentionRegex = /@/igm,
            wordInCursorIsMention = mentionRegex.test(currentWordInCursor.word);

        // if user is trying to mention
        if (wordInCursorIsMention) {
            wordInCursor.current = currentWordInCursor;

            setMentionChars(currentWordInCursor.word.substring(1));

            // if user already mentioning (adding/removing characters from mention)
            if (!mentioning) {
                // if user just started mentioning

                // disable textarea input enter/spacebar (only one stroke)
                textareaRef.current.addEventListener('keydown', oneTimeDisableInput);
                // disable textarea arrows
                textareaRef.current.addEventListener('keydown', disableInputArrows);

                // calculate cursor position
                updateShadowInput(shadowTextareaRef.current, text);
                const dimensions = getPositionInInput(textareaRef.current, shadowTextareaRef.current, currentWordInCursor.startIndex + 1);

                setMentioning(true);
                setMentionPositionData(dimensions);
            }
        } else {
            // if user isn't trying to mention
            // if user just ended doing a mention (deleted mention characters including @)
            if (mentioning) {
                setMentioning(false);

                // enable arrows
                textareaRef.current.removeEventListener('keydown', disableInputArrows);

                // remove one time spacebar/enter block
                textareaRef.current.removeEventListener('keydown', oneTimeDisableInput);
            }
        }
    };

    const handleChange = (e) => {
        // check for mentions (@name)
        checkForMentions(e.target.value);

        props.handleChange(e);
    };

    const applySelectedMention = (user, event) => {
        const newText = getTextWithMention(user.mention_name);
        closeMention(user.mention_name, event);

        props.handleChange({
            target: {
                name: props.name,
                value: newText,
                user: user
            }
        });
    };

    useEffect(() => {
        if (props.label) {
            createFormInput([formTextareaRef.current]);
        }
    }, []);

    useEffect(() => {
        // disable enter for space
        if (props.disableEnter) {
            // disable enter key
            textareaRef.current.addEventListener('keypress', disableEnterKey);
        }

        return () => {
            if (props.disableEnter) {
                textareaRef.current.removeEventListener('keypress', disableEnterKey);
            }
        };
    });

    useEffect(() => {
        // submit content on enter key press
        if (props.submitOnEnter) {
            textareaRef.current.addEventListener('keypress', submitOnEnterKeyPress);
            textareaRef.current.addEventListener('keypress', addNewlineOnShiftEnterKeyPress);

            // disable enter key
            textareaRef.current.addEventListener('keypress', disableEnterKey);

            // insert newline on shift + enter
            textareaRef.current.addEventListener('keydown', savePressedKey);
            textareaRef.current.addEventListener('keyup', resetPressedKey);
        }

        return () => {
            if (props.submitOnEnter) {
                textareaRef.current.removeEventListener('keypress', submitOnEnterKeyPress);
                textareaRef.current.removeEventListener('keypress', addNewlineOnShiftEnterKeyPress);

                textareaRef.current.removeEventListener('keypress', disableEnterKey);

                textareaRef.current.removeEventListener('keydown', savePressedKey);
                textareaRef.current.removeEventListener('keyup', resetPressedKey);
            }
        };
    });

    useLayoutEffect(() => {
        // if text changed, refresh textarea size
        updateTextareaDimensions();
    }, [props.value]);

    useEffect(() => {
        if (!mounting.current) {
            clearInput();
        } else {
            mounting.current = false;
        }
    }, [props.clearInput]);

    useEffect(() => {
        if (props.focus && textareaRef.current) {
            // set cursor to end of textarea after focus
            const selectionPosition = textareaRef.current.value.length * 2;
            textareaRef.current.setSelectionRange(selectionPosition, selectionPosition);
        }
    }, [props.focus]);

    return (
        <div ref={formTextareaRef} className={`form-textarea ${props.kind === 'activity' ? 'pb-12 rounded-bl-default rounded-br-default' : ''} ${props.focus ? 'active' : ''} ${props.modifiers || ''}`}>
            {/* FORM TEXTAREA SHADOW */}
            <p ref={shadowTextareaRef} className={`form-textarea-shadow ${props.modifiers || ''}`}></p>
            {/* FORM TEXTAREA SHADOW */}

            {/* LABEL */}
            {
                props.label &&
                <label className={`${props.loading ? 'label-disabled' : ''}`}>{props.label}</label>
            }
            {/* LABEL */}

            {/* MENTION LIST */}
            {
                props.userFriends && mentioning &&
                <MentionList data={props.userFriends}
                             searchText={mentionChars}
                             positionData={mentionPositionData}
                             onItemSelection={applySelectedMention}
                />
            }
            {/* MENTION LIST */}

            {/* TEXTAREA */}
            <div
                className="rounded-default overflow-hidden">
                <label htmlFor="description" className="sr-only">
                    Description
                </label>
                <textarea
                    rows={2}
                    id="activity-post-form-area"
                    placeholder={''}
                    ref={textareaRef}
                    name={props.name}
                    value={props.value}
                    className={`block w-full border-0 py-0 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm ${props.loading ? 'input-disabled' : ''} ${props.error ? 'input-error' : ''}`}
                    {...(props.placeholder ? {placeholder: props.placeholder} : {})}
                    maxLength={maxLength.current}
                    autoFocus={props.focus}
                    disabled={props.disabled}
                    onChange={handleChange}
                    wrap={'hard'}
                />
            </div>
            {/* TEXTAREA */}

            {
                !props.hideLimit &&
                <div className={`form-textarea-limit ${props.modifiers || ''}`}>
                    {
                        props.loading &&
                        <LoaderSpinner/>
                    }
                    <p className="form-textarea-limit-text">{props.value.length}/{maxLength.current}</p>
                </div>
            }
        </div>
    );
}

export {ExpandableTextarea as default};
