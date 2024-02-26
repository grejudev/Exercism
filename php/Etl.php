<?php

/*
Introduction
You work for a company that makes an online multiplayer game called Lexiconia.

To play the game, each player is given 13 letters, which they must rearrange to create words. Different letters have different point values, since it's easier to create words with some letters than others.

The game was originally launched in English, but it is very popular, and now the company wants to expand to other languages as well.

Different languages need to support different point values for letters. The point values are determined by how often letters are used, compared to other letters in that language.

For example, the letter 'C' is quite common in English, and is only worth 3 points. But in Norwegian it's a very rare letter, and is worth 10 points.

To make it easier to add new languages, your team needs to change the way letters and their point values are stored in the game.

Instructions
Your task is to change the data format of letters and their point values in the game.

Currently, letters are stored in groups based on their score, in a one-to-many mapping.

1 point: "A", "E", "I", "O", "U", "L", "N", "R", "S", "T",
2 points: "D", "G",
3 points: "B", "C", "M", "P",
4 points: "F", "H", "V", "W", "Y",
5 points: "K",
8 points: "J", "X",
10 points: "Q", "Z",
This needs to be changed to store each individual letter with its score in a one-to-one mapping.

"a" is worth 1 point.
"b" is worth 3 points.
"c" is worth 3 points.
"d" is worth 2 points.
etc.
As part of this change, the team has also decided to change the letters to be lower-case rather than upper-case.

Note
If you want to look at how the data was previously structured and how it needs to change, take a look at the examples in the test suite.
 */

declare(strict_types=1);

function transform(array $input): array
{
    $newArr = [];
    $numLetters = 0;
    foreach ($input as $key => $letters) {
        foreach ($letters as $letter) {
            $newArr[strtolower($letter)] = (int)$key;
            $numLetters++;
        }
    }
    return $newArr;
}

$old = [
    '1' => str_split('AEIOULNRST'),
    '2' => str_split('DG'),
    '3' => str_split('BCMP'),
    '4' => str_split('FHVWY'),
    '5' => str_split('K'),
    '8' => str_split('JX'),
    '10' => str_split('QZ'),
];
$expected = [
    'a' => 1, 'b' => 3, 'c' => 3, 'd' => 2, 'e' => 1,
    'f' => 4, 'g' => 2, 'h' => 4, 'i' => 1, 'j' => 8,
    'k' => 5, 'l' => 1, 'm' => 3, 'n' => 1, 'o' => 1,
    'p' => 3, 'q' => 10, 'r' => 1, 's' => 1, 't' => 1,
    'u' => 1, 'v' => 4, 'w' => 4, 'x' => 8, 'y' => 4,
    'z' => 10,
];
echo '<pre>';
print_r(transform($old));
echo '</pre>';
