<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

//  Instructions
// The Collatz Conjecture or 3x+1 problem can be summarized as follows:
// Take any positive integer n. If n is even, divide n by 2 to get n / 2. If n is odd, multiply n by 3 and add 1 to get 3n + 1. Repeat the process indefinitely.

declare(strict_types=1);

function steps(int $number): int
{
    if ($number == 0 || $number < 0) {
        throw new InvalidArgumentException('Only positive numbers are allowed');
    }
    $steps = 0;
    while ($number !== 1) {
        if ($number % 2 == 0) {
            $number /= 2;
        } else {
            $number = $number * 3 + 1;
        }
        $steps++;
    }
    return $steps;
}
