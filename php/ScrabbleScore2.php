<?php

/*
 Instructions
Given a word, compute the Scrabble score for that word.

Letter Values
You'll need these:

Letter                           Value
A, E, I, O, U, L, N, R, S, T       1
D, G                               2
B, C, M, P                         3
F, H, V, W, Y                      4
K                                  5
J, X                               8
Q, Z                               10
Examples
"cabbage" should be scored as worth 14 points:

3 points for C
1 point for A, twice
3 points for B, twice
2 points for G
1 point for E
And to total:

3 + 2*1 + 2*3 + 2 + 1
= 3 + 2 + 6 + 3
= 5 + 9
= 14
Extensions
You can play a double or a triple letter.
You can play a double or a triple word.
 */

declare(strict_types=1);

function score(string $word): int
{
    return array_reduce(
        str_split($word),
        fn ($total, $letter) => $total + letter($letter),
        0
    );
}
function letter(string $letter): int
{
    return match (strtolower($letter)) {
        "a", "e", "i", "o", "u", "l", "n", "r", "s", "t" => 1,
        "d", "g" => 2,
        "b", "c", "m", "p" => 3,
        "f", "h", "v", "w", "y" => 4,
        "k" => 5,
        "j", "x" => 8,
        "q", "z" => 10,
        default => 0,
    };
}
