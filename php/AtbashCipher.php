<?php

/*
Instructions
Create an implementation of the atbash cipher, an ancient encryption system created in the Middle East.

The Atbash cipher is a simple substitution cipher that relies on transposing all the letters in the alphabet such that the resulting alphabet is backwards. The first letter is replaced with the last letter, the second with the second-last, and so on.

An Atbash cipher for the Latin alphabet would be as follows:

Plain:  abcdefghijklmnopqrstuvwxyz
Cipher: zyxwvutsrqponmlkjihgfedcba
It is a very weak cipher because it only has one possible key, and it is a simple monoalphabetic substitution cipher. However, this may not have been an issue in the cipher's time.

Ciphertext is written out in groups of fixed length, the traditional group size being 5 letters, and punctuation is excluded. This is to make it harder to guess things based on word boundaries.

Examples
Encoding test gives gvhg
Decoding gvhg gives test
Decoding gsvjf rxpyi ldmul cqfnk hlevi gsvoz abwlt gives thequickbrownfoxjumpsoverthelazydog
*/

declare(strict_types=1);

function encode(string $text): string
{
    $output = "";
    $plain = str_split('abcdefghijklmnopqrstuvwxyz');
    $cipher = str_split('zyxwvutsrqponmlkjihgfedcba');

    $text = strtolower($text);
    $textCleaned = str_replace(' ', '', $text); // Replaces all spaces with hyphens.
    $textCleaned = preg_replace('/[^A-Za-z0-9\-]/', '', $textCleaned); // Removes special chars.

    $textSplitted = str_split($textCleaned);
    $textSplitted_length = count($textSplitted);
    for ($i = 0; $i < $textSplitted_length; $i++) {
        $code = mb_ord($textSplitted[$i], "UTF-8");

        if ($i % 5 === 0 && $i !== 0) {
            $output .= " ";
        }

        if ($code >= 97 && $code <= 122) {
            $index = $code - 97;
            $output .= $cipher[$index];
        } else {
            $output .= $textSplitted[$i];
        }
    }

    return $output;
}

// echo '<pre>';
// print_r(encode('Testing, 1 2 3, testing.'));
// echo '</pre>';
