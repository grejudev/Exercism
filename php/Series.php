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

function slices(string $digits, int $series): array
{
    $digits = str_split($digits);
    $digits_length = count($digits);

    if ($series <= 0 || $series > $digits_length) {
        throw new \InvalidArgumentException('Invalid input');
    }

    $result = [];

    $beginSeries = 0;
    $finalIndexToCheck = $digits_length - $series;
    for ($i = $beginSeries; $i <= $finalIndexToCheck; $i++) {
        if ($beginSeries <= $finalIndexToCheck) {
            $arr = array_slice($digits, $i, $series, true);
            $substring = implode("", $arr);
            array_push($result, $substring);
        }
    }

    return $result;
}

echo '<pre>';
print_r(slices("97867564", 3));
echo '</pre>';
