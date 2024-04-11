<?php

/*
Introduction
Raindrops is a slightly more complex version of the FizzBuzz challenge, a classic interview question.

Instructions
Your task is to convert a number into its corresponding raindrop sounds.

If a given number:

is divisible by 3, add "Pling" to the result.
is divisible by 5, add "Plang" to the result.
is divisible by 7, add "Plong" to the result.
is not divisible by 3, 5, or 7, the result should be the number as a string.
Examples
28 is divisible by 7, but not 3 or 5, so the result would be "Plong".
30 is divisible by 3 and 5, but not 7, so the result would be "PlingPlang".
34 is not divisible by 3, 5, or 7, so the result would be "34".
 */

declare(strict_types=1);

function raindrops(int $number): string
{
    $result = "";
    return match (0) {
        $number % 105 => $result .= "PlingPlangPlong",
        $number % 35  => $result .= "PlangPlong",
        $number % 21  => $result .= "PlingPlong",
        $number % 15 => $result .= "PlingPlang",
        $number % 3 => $result .= "Pling",
        $number % 5  => $result .= "Plang",
        $number % 7  => $result .= "Plong",
        default   => $result .= $number,
    };
}
