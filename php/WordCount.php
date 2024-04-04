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

use function PHPSTORM_META\map;

function wordCount(string $words): array
{
    $words = preg_replace('/(?<=\w)\'(?=\w)/', '_', $words);
    $words = preg_replace('/[^A-Za-z0-9\_]/', ' ', $words);
    $words = preg_replace('/\s+/', ' ', $words);
    $words = str_replace('_', "'", $words);
    $words = trim($words);
    $words = strtolower($words);

    $words = explode(' ', $words);
    $result = array_count_values($words);

    return $result;
}

$subtitle = "'That's the password: 'PASSWORD 123'!', cried the Special Agent.\nSo I fled.";

echo '<pre>';
print_r(wordCount($subtitle));
echo '</pre>';
