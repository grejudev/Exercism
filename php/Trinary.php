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

declare(strict_types=1);

function toDecimal(string $number): int
{
    $result = 0;
    $sum = [];
    $number_length = strlen($number);
    $exponent = $number_length - 1;
    for ($i = 0; $i < $number_length; $i++) {
        $n = $number[$i];

        if (!in_array($n, ['0', '1', '2'])) {
            return 0; // Invalid digit
        }

        $value = $n * pow(3, $exponent);
        array_push($sum, $value);
        $exponent--;
    }

    $result = array_reduce($sum, fn ($previous, $current) => $previous + $current);

    return $result;
}
