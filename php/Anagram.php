<?php
/*
Instructions
An anagram is a rearrangement of letters to form a new word. Given a word and a list of candidates, select the sublist of anagrams of the given word.

Given "listen" and a list of candidates like "enlists" "google" "inlets" "banana" the program should return a list containing "inlets".

The skipped tests near the bottom of the anagram_test.php are Stretch Goals, they are optional. They require the usage of mb_string functions, which aren't installed by default with every version of PHP.
*/

declare(strict_types=1);

function detectAnagrams(string $word, array $anagrams): array
{
    $word_lower = strtolower($word);
    $wordSorted = sortString(strtolower($word));
    $words = [];
    foreach ($anagrams as $w) {
        if ($wordSorted === sortString(strtolower($w)) && strtolower($w) !== $word_lower) {
            $words[] = $w;
        }
    }
    return $words;
}
function sortString($string)
{
    $stringParts = str_split($string);
    sort($stringParts);
    return implode($stringParts);
}

// echo '<pre>';
// print_r(detectAnagrams('listen', ['enlists', 'google', 'inlets', 'banana']));
// echo '</pre>';
