<?php

declare(strict_types=1);

/*
 * Polyfill for mb_ltrim() which is only available in PHP 8.4+
 *
 * This file provides backward compatibility for the mb_ltrim() function
 * introduced in PHP 8.4.0, allowing the codebase to work with PHP 8.0-8.3.
 */

if (!function_exists('mb_ltrim')) {
    /**
     * Strip whitespace (or other characters) from the beginning of a string using multibyte encoding.
     *
     * @param string $string The input string
     * @param non-empty-string $characters The characters to strip
     * @param string|null $encoding The character encoding. If null, the internal character encoding is used.
     *
     * @return string The trimmed string
     */
    function mb_ltrim(string $string, string $characters = " \n\r\t\v\0", ?string $encoding = null): string
    {
        $encoding = $encoding ?? mb_internal_encoding();

        $characterArray = preg_split('//u', $characters, -1, PREG_SPLIT_NO_EMPTY);
        if ($characterArray === false) {
            return $string;
        }

        $pattern = '/^[' . preg_quote(implode('', $characterArray), '/') . ']+/u';

        return (string) preg_replace($pattern, '', $string);
    }
}
