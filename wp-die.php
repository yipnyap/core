<?php
if (!headers_sent()) {
    status_header($r['response']);
    nocache_headers();
    header('Content-Type: text/html; charset=utf-8');
}

$text_direction = 'ltr';
if ((isset($r['text_direction']) && 'rtl' == $r['text_direction']) || (function_exists('is_rtl') && is_rtl())) :
    $text_direction = 'rtl';
endif;

?><!DOCTYPE html>

<html lang="en-AU">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <style id="_style">
        /*! tailwindcss v2.1.2 | MIT License | https://tailwindcss.com */ /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */

        /* Document
  ========================================================================== */

        /**
  * 1. Correct the line height in all browsers.
  * 2. Prevent adjustments of font size after orientation changes in iOS.
  */

        html {
            line-height: 1.15; /* 1 */
            -webkit-text-size-adjust: 100%; /* 2 */
        }

        /* Sections
  ========================================================================== */

        /**
  * Remove the margin in all browsers.
  */

        body {
            margin: 0;
        }

        /**
  * Render the `main` element consistently in IE.
  */

        main {
            display: block;
        }

        /**
  * Correct the font size and margin on `h1` elements within `section` and
  * `article` contexts in Chrome, Firefox, and Safari.
  */

        h1 {
            font-size: 2em;
            margin: 0.67em 0;
        }

        /* Grouping content
  ========================================================================== */

        /**
  * 1. Add the correct box sizing in Firefox.
  * 2. Show the overflow in Edge and IE.
  */

        hr {
            box-sizing: content-box; /* 1 */
            height: 0; /* 1 */
            overflow: visible; /* 2 */
        }

        /**
  * 1. Correct the inheritance and scaling of font size in all browsers.
  * 2. Correct the odd `em` font sizing in all browsers.
  */

        pre {
            font-family: monospace, monospace; /* 1 */
            font-size: 1em; /* 2 */
        }

        /* Text-level semantics
  ========================================================================== */

        /**
  * Remove the gray background on active links in IE 10.
  */

        a {
            background-color: transparent;
        }

        /**
  * 1. Remove the bottom border in Chrome 57-
  * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
  */

        abbr[title] {
            border-bottom: none; /* 1 */
            text-decoration: underline; /* 2 */
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted; /* 2 */
        }

        /**
  * Add the correct font weight in Chrome, Edge, and Safari.
  */

        b,
        strong {
            font-weight: bolder;
        }

        /**
  * 1. Correct the inheritance and scaling of font size in all browsers.
  * 2. Correct the odd `em` font sizing in all browsers.
  */

        code,
        kbd,
        samp {
            font-family: monospace, monospace; /* 1 */
            font-size: 1em; /* 2 */
        }

        /**
  * Add the correct font size in all browsers.
  */

        small {
            font-size: 80%;
        }

        /**
  * Prevent `sub` and `sup` elements from affecting the line height in
  * all browsers.
  */

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }

        sub {
            bottom: -0.25em;
        }

        sup {
            top: -0.5em;
        }

        /* Embedded content
  ========================================================================== */

        /**
  * Remove the border on images inside links in IE 10.
  */

        img {
            border-style: none;
        }

        /* Forms
  ========================================================================== */

        /**
  * 1. Change the font styles in all browsers.
  * 2. Remove the margin in Firefox and Safari.
  */

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit; /* 1 */
            font-size: 100%; /* 1 */
            line-height: 1.15; /* 1 */
            margin: 0; /* 2 */
        }

        /**
  * Show the overflow in IE.
  * 1. Show the overflow in Edge.
  */

        button,
        input {
            /* 1 */
            overflow: visible;
        }

        /**
  * Remove the inheritance of text transform in Edge, Firefox, and IE.
  * 1. Remove the inheritance of text transform in Firefox.
  */

        button,
        select {
            /* 1 */
            text-transform: none;
        }

        /**
  * Correct the inability to style clickable types in iOS and Safari.
  */

        button,
        [type="button"],
        [type="reset"],
        [type="submit"] {
            -webkit-appearance: button;
        }

        /**
  * Remove the inner border and padding in Firefox.
  */

        button::-moz-focus-inner,
        [type="button"]::-moz-focus-inner,
        [type="reset"]::-moz-focus-inner,
        [type="submit"]::-moz-focus-inner {
            border-style: none;
            padding: 0;
        }

        /**
  * Restore the focus styles unset by the previous rule.
  */

        button:-moz-focusring,
        [type="button"]:-moz-focusring,
        [type="reset"]:-moz-focusring,
        [type="submit"]:-moz-focusring {
            outline: 1px dotted ButtonText;
        }

        /**
  * Correct the padding in Firefox.
  */

        fieldset {
            padding: 0.35em 0.75em 0.625em;
        }

        /**
  * 1. Correct the text wrapping in Edge and IE.
  * 2. Correct the color inheritance from `fieldset` elements in IE.
  * 3. Remove the padding so developers are not caught out when they zero out
  *    `fieldset` elements in all browsers.
  */

        legend {
            box-sizing: border-box; /* 1 */
            color: inherit; /* 2 */
            display: table; /* 1 */
            max-width: 100%; /* 1 */
            padding: 0; /* 3 */
            white-space: normal; /* 1 */
        }

        /**
  * Add the correct vertical alignment in Chrome, Firefox, and Opera.
  */

        progress {
            vertical-align: baseline;
        }

        /**
  * Remove the default vertical scrollbar in IE 10+.
  */

        textarea {
            overflow: auto;
        }

        /**
  * 1. Add the correct box sizing in IE 10.
  * 2. Remove the padding in IE 10.
  */

        [type="checkbox"],
        [type="radio"] {
            box-sizing: border-box; /* 1 */
            padding: 0; /* 2 */
        }

        /**
  * Correct the cursor style of increment and decrement buttons in Chrome.
  */

        [type="number"]::-webkit-inner-spin-button,
        [type="number"]::-webkit-outer-spin-button {
            height: auto;
        }

        /**
  * 1. Correct the odd appearance in Chrome and Safari.
  * 2. Correct the outline style in Safari.
  */

        [type="search"] {
            -webkit-appearance: textfield; /* 1 */
            outline-offset: -2px; /* 2 */
        }

        /**
  * Remove the inner padding in Chrome and Safari on macOS.
  */

        [type="search"]::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        /**
  * 1. Correct the inability to style clickable types in iOS and Safari.
  * 2. Change font properties to `inherit` in Safari.
  */

        ::-webkit-file-upload-button {
            -webkit-appearance: button; /* 1 */
            font: inherit; /* 2 */
        }

        /* Interactive
  ========================================================================== */

        /*
  * Add the correct display in Edge, IE 10+, and Firefox.
  */

        details {
            display: block;
        }

        /*
  * Add the correct display in all browsers.
  */

        summary {
            display: list-item;
        }

        /* Misc
  ========================================================================== */

        /**
  * Add the correct display in IE 10+.
  */

        template {
            display: none;
        }

        /**
  * Add the correct display in IE 10.
  */

        [hidden] {
            display: none;
        }

        /**
       * Manually forked from SUIT CSS Base: https://github.com/suitcss/base
       * A thin layer on top of normalize.css that provides a starting point more
       * suitable for web applications.
       */

        /**
  * Removes the default spacing and border for appropriate elements.
  */

        blockquote,
        dl,
        dd,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        figure,
        p,
        pre {
            margin: 0;
        }

        button {
            background-color: transparent;
            background-image: none;
        }

        /**
  * Work around a Firefox/IE bug where the transparent `button` background
  * results in a loss of the default `button` focus styles.
  */

        button:focus {
            outline: 1px dotted;
            outline: 5px auto -webkit-focus-ring-color;
        }

        fieldset {
            margin: 0;
            padding: 0;
        }

        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        /**
  * Tailwind custom reset styles
  */

        /**
  * 1. Use the user's configured `sans` font-family (with Tailwind's default
  *    sans-serif font stack as a fallback) as a sane default.
  * 2. Use Tailwind's default "normal" line-height so the user isn't forced
  *    to override it to ensure consistency even when using the default theme.
  */

        html {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
            "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif,
            "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol",
            "Noto Color Emoji"; /* 1 */
            line-height: 1.5; /* 2 */
        }

        /**
  * Inherit font-family and line-height from `html` so users can set them as
  * a class directly on the `html` element.
  */

        body {
            font-family: inherit;
            line-height: inherit;
        }

        /**
  * 1. Prevent padding and border from affecting element width.
  *
  *    We used to set this in the html element and inherit from
  *    the parent element for everything else. This caused issues
  *    in shadow-dom-enhanced elements like <details> where the content
  *    is wrapped by a div with box-sizing set to `content-box`.
  *
  *    https://github.com/mozdevs/cssremedy/issues/4
  *
  *
  * 2. Allow adding a border to an element by just adding a border-width.
  *
  *    By default, the way the browser specifies that an element should have no
  *    border is by setting it's border-style to `none` in the user-agent
  *    stylesheet.
  *
  *    In order to easily add borders to elements by just setting the `border-width`
  *    property, we change the default border-style for all elements to `solid`, and
  *    use border-width to hide them instead. This way our `border` utilities only
  *    need to set the `border-width` property instead of the entire `border`
  *    shorthand, making our border utilities much more straightforward to compose.
  *
  *    https://github.com/tailwindcss/tailwindcss/pull/116
  */

        *,
        ::before,
        ::after {
            box-sizing: border-box; /* 1 */
            border-width: 0; /* 2 */
            border-style: solid; /* 2 */
            border-color: #e5e7eb; /* 2 */
        }

        /*
  * Ensure horizontal rules are visible by default
  */

        hr {
            border-top-width: 1px;
        }

        /**
  * Undo the `border-style: none` reset that Normalize applies to images so that
  * our `border-{width}` utilities have the expected effect.
  *
  * The Normalize reset is unnecessary for us since we default the border-width
  * to 0 on all elements.
  *
  * https://github.com/tailwindcss/tailwindcss/issues/362
  */

        img {
            border-style: solid;
        }

        textarea {
            resize: vertical;
        }

        input::-moz-placeholder,
        textarea::-moz-placeholder {
            opacity: 1;
            color: #9ca3af;
        }

        input:-ms-input-placeholder,
        textarea:-ms-input-placeholder {
            opacity: 1;
            color: #9ca3af;
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af;
        }

        button,
        [role="button"] {
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit;
        }

        /**
  * Reset links to optimize for opt-in styling instead of
  * opt-out.
  */

        a {
            color: inherit;
            text-decoration: inherit;
        }

        /**
  * Reset form element properties that are easy to forget to
  * style explicitly so you don't inadvertently introduce
  * styles that deviate from your design system. These styles
  * supplement a partial reset that is already applied by
  * normalize.css.
  */

        button,
        input,
        optgroup,
        select,
        textarea {
            padding: 0;
            line-height: inherit;
            color: inherit;
        }

        /**
  * Use the configured 'mono' font family for elements that
  * are expected to be rendered with a monospace font, falling
  * back to the system monospace stack if there is no configured
  * 'mono' font family.
  */

        pre,
        code,
        kbd,
        samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas,
            "Liberation Mono", "Courier New", monospace;
        }

        /**
  * Make replaced elements `display: block` by default as that's
  * the behavior you want almost all of the time. Inspired by
  * CSS Remedy, with `svg` added as well.
  *
  * https://github.com/mozdevs/cssremedy/issues/14
  */

        img,
        svg,
        video,
        canvas,
        audio,
        iframe,
        embed,
        object {
            display: block;
            vertical-align: middle;
        }

        /**
  * Constrain images and videos to the parent width and preserve
  * their intrinsic aspect ratio.
  *
  * https://github.com/mozdevs/cssremedy/issues/14
  */

        img,
        video {
            max-width: 100%;
            height: auto;
        }

        * {
            --tw-shadow: 0 0 #0000;
            --tw-ring-inset: var(--tw-empty, /*!*/ /*!*/);
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgba(59, 130, 246, 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }

        .fixed {
            position: fixed;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .z-10 {
            z-index: 10;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .ml-2 {
            margin-left: 0.5rem;
        }

        .mt-3 {
            margin-top: 0.75rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .inline-block {
            display: inline-block;
        }

        .flex {
            display: flex;
        }

        .inline-flex {
            display: inline-flex;
        }

        .hidden {
            display: none;
        }

        .h-7 {
            height: 1.75rem;
        }

        .h-6 {
            height: 1.5rem;
        }

        .h-5 {
            height: 1.25rem;
        }

        .h-12 {
            height: 3rem;
        }

        .h-8 {
            height: 2rem;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        .w-5 {
            width: 1.25rem;
        }

        .w-12 {
            width: 3rem;
        }

        .w-full {
            width: 100%;
        }

        .max-w-md {
            max-width: 28rem;
        }

        .flex-shrink-0 {
            flex-shrink: 0;
        }

        .transform {
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .-skew-y-6 {
            --tw-skew-y: -6deg;
        }

        .list-disc {
            list-style-type: disc;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-start {
            align-items: flex-start;
        }

        .items-center {
            align-items: center;
        }

        .items-end {
            align-items: flex-end;
        }

        .justify-center {
            justify-content: center;
        }

        .space-y-4 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(1rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(1rem * var(--tw-space-y-reverse));
        }

        .space-y-2 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
        }

        .divide-y > :not([hidden]) ~ :not([hidden]) {
            --tw-divide-y-reverse: 0;
            border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
            border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
        }

        .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
            --tw-divide-opacity: 1;
            border-color: rgba(229, 231, 235, var(--tw-divide-opacity));
        }

        .overflow-y-auto {
            overflow-y: auto;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .whitespace-pre-line {
            white-space: pre-line;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .rounded-default {
            border-radius: 0.375rem;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-300 {
            --tw-border-opacity: 1;
            border-color: rgba(209, 213, 219, var(--tw-border-opacity));
        }

        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
        }

        .bg-gray-500 {
            --tw-bg-opacity: 1;
            background-color: rgba(107, 114, 128, var(--tw-bg-opacity));
        }

        .bg-red-500 {
            --tw-bg-opacity: 1;
            background-color: rgba(239, 68, 68, var(--tw-bg-opacity));
        }

        .bg-gray-50 {
            --tw-bg-opacity: 1;
            background-color: rgba(249, 250, 251, var(--tw-bg-opacity));
        }

        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }

        .from-cyan-400 {
            --tw-gradient-from: #22d3ee;
            --tw-gradient-stops: var(--tw-gradient-from),
            var(--tw-gradient-to, rgba(34, 211, 238, 0));
        }

        .to-light-blue-500 {
            --tw-gradient-to: #0ea5e9;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-10 {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
        }

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .pt-6 {
            padding-top: 1.5rem;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .pb-20 {
            padding-bottom: 5rem;
        }

        .pt-5 {
            padding-top: 1.25rem;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .align-bottom {
            vertical-align: bottom;
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-medium {
            font-weight: 500;
        }

        .leading-6 {
            line-height: 1.5rem;
        }

        .text-gray-700 {
            --tw-text-opacity: 1;
            color: rgba(55, 65, 81, var(--tw-text-opacity));
        }

        .text-cyan-500 {
            --tw-text-opacity: 1;
            color: rgba(6, 182, 212, var(--tw-text-opacity));
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgba(17, 24, 39, var(--tw-text-opacity));
        }

        .text-cyan-600 {
            --tw-text-opacity: 1;
            color: rgba(8, 145, 178, var(--tw-text-opacity));
        }

        .text-white {
            --tw-text-opacity: 1;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgba(107, 114, 128, var(--tw-text-opacity));
        }

        .opacity-75 {
            opacity: 0.75;
        }

        .shadow-lg {
            --tw-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
            0 4px 6px -2px rgba(0, 0, 0, 0.05);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000),
            var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }

        .shadow-xl {
            --tw-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
            0 10px 10px -5px rgba(0, 0, 0, 0.04);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000),
            var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }

        .shadow-sm {
            --tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000),
            var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }

        .transition-opacity {
            transition-property: opacity;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .hover\:bg-gray-50:hover {
            --tw-bg-opacity: 1;
            background-color: rgba(249, 250, 251, var(--tw-bg-opacity));
        }

        .hover\:text-cyan-700:hover {
            --tw-text-opacity: 1;
            color: rgba(14, 116, 144, var(--tw-text-opacity));
        }

        .focus\:outline-none:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .focus\:ring-2:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow),
            var(--tw-shadow, 0 0 #0000);
        }

        .focus\:ring-indigo-500:focus {
            --tw-ring-opacity: 1;
            --tw-ring-color: rgba(99, 102, 241, var(--tw-ring-opacity));
        }

        .focus\:ring-offset-2:focus {
            --tw-ring-offset-width: 2px;
        }

        @media (min-width: 640px) {
            .sm\:mx-auto {
                margin-left: auto;
                margin-right: auto;
            }

            .sm\:my-8 {
                margin-top: 2rem;
                margin-bottom: 2rem;
            }

            .sm\:mt-0 {
                margin-top: 0;
            }

            .sm\:ml-4 {
                margin-left: 1rem;
            }

            .sm\:ml-3 {
                margin-left: 0.75rem;
            }

            .sm\:block {
                display: block;
            }

            .sm\:inline-block {
                display: inline-block;
            }

            .sm\:flex {
                display: flex;
            }

            .sm\:h-8 {
                height: 2rem;
            }

            .sm\:h-7 {
                height: 1.75rem;
            }

            .sm\:h-screen {
                height: 100vh;
            }

            .sm\:w-full {
                width: 100%;
            }

            .sm\:w-auto {
                width: auto;
            }

            .sm\:max-w-xl {
                max-width: 36rem;
            }

            .sm\:max-w-lg {
                max-width: 32rem;
            }

            .sm\:-rotate-6 {
                --tw-rotate: -6deg;
            }

            .sm\:skew-y-0 {
                --tw-skew-y: 0deg;
            }

            .sm\:flex-row-reverse {
                flex-direction: row-reverse;
            }

            .sm\:items-start {
                align-items: flex-start;
            }

            .sm\:rounded-3xl {
                border-radius: 1.5rem;
            }

            .sm\:p-20 {
                padding: 5rem;
            }

            .sm\:p-0 {
                padding: 0;
            }

            .sm\:p-6 {
                padding: 1.5rem;
            }

            .sm\:py-12 {
                padding-top: 3rem;
                padding-bottom: 3rem;
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .sm\:pb-4 {
                padding-bottom: 1rem;
            }

            .sm\:text-left {
                text-align: left;
            }

            .sm\:align-middle {
                vertical-align: middle;
            }

            .sm\:text-lg {
                font-size: 1.125rem;
                line-height: 1.75rem;
            }

            .sm\:text-sm {
                font-size: 0.875rem;
                line-height: 1.25rem;
            }

            .sm\:leading-7 {
                line-height: 1.75rem;
            }
        }
    </style>
    <title>Yipnyap Died</title>
</head>
<body
        style=""
        data-new-gr-c-s-check-loaded="14.1012.0"
        data-gr-ext-installed=""
>
<div class="fixed z-10 inset-0 overflow-y-auto">
    <div
            class="
          flex
          items-end
          justify-center
          min-h-screen
          pt-4
          px-4
          pb-20
          text-center
          sm:block
          sm:p-0
        "
    >
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
        ></span>
        <div
                class="
            inline-block
            align-bottom
            bg-white
            rounded-lg
            text-left
            overflow-hidden
            shadow-xl
            transform
            transition-all
            sm:my-8
            sm:align-middle
            sm:max-w-lg
            sm:w-full
          "
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline"
        >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                            class="
                  mx-auto
                  flex-shrink-0 flex
                  items-center
                  justify-center
                  bg-red-500
                  rounded-xl
                  shadow-lg
                  w-12
                  h-12
                "
                    >
                        <img
                                class="h-8 text-white"
                                src="data:image/gif;base64,R0lGODlhKgAtAPIHAP//mf/MAJmZmWZmZv9mM8zMzAAAAP///yH5BAUAAAcALAAAAAAqAC0AAAP3eLrc/jDKSau9OOvNeyegl4GEiJGmRhps67Kpsr50fMy0a+JB3wrAnLDW4PlYQMFwCSuCWr3AL8gcOqA9gDbaKni73jBN3DxgA1oAl0U2hNvgQmtxTq/dX/Zb/mrTWWlhOG17b3FzCi2BXoN5eIV8j4hmgFqCT3qRkI5+iZUAlwRTSkhJpqQGSZOKloyYqVSwp7GqZaygrqKlqLO1sqssUXZHBgPGLcbJysjHtsFZW8TJzMrTLNYGfwbC0VLXzcXV2NgLRt7hA1VWTrrb0uDqLw7m1PE5ETjrKflCNvz3IlDYmCBwIL4QBhMqXMiwocOHECNKnKggAQA7"
                                style="padding-left: 2px; image-rendering: pixelated"
                                alt="electric torch"
                        />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3
                                class="text-lg leading-6 font-medium text-gray-900"
                                id="modal-headline"
                        >
                            Yipnyap got confused...
                        </h3>
                        <div class="mt-2">
                  <pre
                          class="
                      mt-2
                      whitespace-pre-line
                      rounded-default
                      p-2
                      bg-gray-100
                      text-gray-500
                      w-full
                    "
                  >
                Fatal | <?php echo $message; ?>
</pre
>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <a href="?attempt=<?php echo round(microtime(true) * 1000) ?>"
                >
                    <button
                            type="button"
                            class="
                  w-full
                  inline-flex
                  justify-center
                  rounded-default
                  border border-gray-300
                  shadow-sm
                  px-4
                  py-2
                  bg-white
                  text-base
                  font-medium
                  text-gray-700
                  hover:bg-gray-50
                  focus:outline-none
                  focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                  sm:mt-0
                  sm:ml-3
                  sm:w-auto
                  sm:text-sm
                "
                    >
                        Reload
                    </button>
                </a
                >
            </div>
        </div>
    </div>
</div>
</body>
</html>
