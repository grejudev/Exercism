<?php

/*
Instructions
Convert a phrase to its acronym.

Techies love their TLA (Three Letter Acronyms)!

Help generate some jargon by writing a program that converts a long name like Portable Network Graphics to its acronym (PNG).
*/

declare(strict_types=1);

function acronym(string $string): string
{
    $string = str_replace('-', ' ', $string);
    $ar = explode(' ', $string);
    $result = '';
    foreach ($ar as $item) {
        $result .= mb_substr($item, 0, 1);
        $itemAsChars = mb_str_split($item);
        for ($i = 1; $i < count($itemAsChars); $i++) {
            if (
                $itemAsChars[$i] === mb_strtoupper($itemAsChars[$i]) &&
                $itemAsChars[$i - 1] === mb_strtolower($itemAsChars[$i - 1])
            ) {
                $result .= $itemAsChars[$i];
            }
        }
    }
    $resultUpper = mb_strtoupper($result);
    return mb_strlen($resultUpper) === 1 ? '' : $resultUpper;
}

// echo '<pre>';
// print_r(acronym('PHP: Hypertext Preprocessor'));
// echo '<br>';
// print_r(acronym('HyperText Markup Language'));
// echo '<br>';
// print_r(acronym('Word'));
// echo '<br>';
// print_r(acronym('СПЧ'));
// echo '</br>';
