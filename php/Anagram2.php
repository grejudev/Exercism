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
    $result = [];

    $wordSplitted = str_split(strtolower($word));
    $wordSplitted_length = count($wordSplitted);

    $anagrams_length = count($anagrams);
    $anagramSplitted = [];

    for ($i = 0; $i < $anagrams_length; $i++) {
        $wordCopy = $wordSplitted;

        $anagram = $anagrams[$i];
        $anagramSplitted = str_split(strtolower($anagram));
        if ($anagramSplitted === $wordSplitted) {
            continue; // Both are equal
        }
        $anagram_copy = $anagramSplitted;

        $anagramSplitted_length = count($anagramSplitted);

        for ($j = 0; $j < $wordSplitted_length; $j++) {
            if ($wordSplitted_length > $anagramSplitted_length) {
                continue;
            }
            // Search letter in $word, then remove letter from copies and then check if both copies are empty
            $letter = $anagramSplitted[$j];
            $indexWordSplitted = array_search($letter, $wordCopy);
            $indexAnagramSplitted = array_search($letter, $anagram_copy);
            if ($indexWordSplitted !== false) {
                unset($wordCopy[$indexWordSplitted]);
                unset($anagram_copy[$indexAnagramSplitted]);
            }
        }
        print_r($wordCopy);
        if (empty($wordCopy) && empty($anagram_copy)) {
            array_push($result, $anagram);
        }
    }
    return $result;
}

// echo '<pre>';
// print_r(detectAnagrams('Orchestra', ['cashregister', 'Carthorse', 'radishes']));
// echo '</pre>';
