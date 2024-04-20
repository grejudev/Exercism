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
function encode(string $text, int $num1, int $num2): string
{
    if ($num1 % 2 === 0 || $num1 % 13 === 0) throw new Exception();

    $encoded = "";
    $alphabet = str_split("abcdefghijklmnopqrstuvwxyz");
    $count = 0;
    foreach (str_split($text) as $letter) {
        if (!preg_match("/[a-z0-9]/i", $letter)) continue;
        if ($count == 5) {
            $encoded .= " ";
            $count = 0;
        }
        if (preg_match("/[0-9]/", $letter)) {
            $encoded .= $letter;
        } else {
            $index = array_search(strtolower($letter), $alphabet);
            $index = ($num1 * $index + $num2) % 26;
            $encoded .= $alphabet[$index];
        }
        $count++;
    }
    return $encoded;
}
function decode(string $text, int $num1, int $num2): string
{
    if ($num1 % 2 === 0 || $num1 % 13 === 0) throw new Exception();

    $text = str_replace(" ", "", $text);
    $alphabet = str_split("abcdefghijklmnopqrstuvwxyz");
    $decoded = "";

    foreach (str_split($text) as $letter) {
        if (!preg_match("/[a-z0-9]/i", $letter)) continue;

        if (preg_match("/[0-9]/", $letter)) {
            $decoded .= $letter;
        } else {
            $index = array_search(strtolower($letter), $alphabet);

            $index = (mmi($num1) * ($index - $num2)) % 26;

            while ($index < 0) $index += 26;

            $decoded .= $alphabet[$index];
        }
    }
    return $decoded;
}
function mmi(int $num): int
{
    for ($mmi = 1; $mmi < 27; $mmi++) {
        if (($mmi * $num % 26) === 1) return $mmi;
    }
    return 1;
}
