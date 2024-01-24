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

function encode(string $plainMessage, int $num_rails): string
{
    $rails = array_fill(0, $num_rails, '');
    $strlength = strlen($plainMessage);
    $top = 0;
    $bottom = $num_rails - 1;
    $current_index = 0;
    $direction = "down";
    for ($i = 0; $i < $strlength; $i++) {
        $char = $plainMessage[$i];
        if ($current_index >= $bottom) {
            $direction = "up";
        } elseif ($current_index <= $top) {
            $direction = "down";
        }

        $rails[$current_index] .= $char;

        if ($direction === "down") {
            $current_index++;
        } else {
            $current_index--;
        }
    }
    $result = implode('', $rails);
    return $result;
}

function decode(string $cipherMessage, int $num_rails): string
{
    $fence = [];
    $chars = str_split($cipherMessage);
    for ($i = 0; $i < $num_rails; $i++) {
        $fence[$i] = array_fill(0, count($chars), null);
    }
    $pattern = range(0, $num_rails - 1);
    if ($num_rails - 2 >= 1) {
        $pattern = array_merge($pattern, range($num_rails - 2, 1));
    }
    for ($i = 0; $i < count($chars); $i++) {
        $rail = $pattern[$i % count($pattern)];
        $fence[$rail][$i] = '*';
    }
    $index = 0;
    for ($y = 0; $y < $num_rails; $y++) {
        for ($x = 0; $x < count($chars); $x++) {
            if ($fence[$y][$x] && $index < count($chars)) {
                $fence[$y][$x] = $chars[$index++];
            }
        }
    }
    $result = "";
    for ($i = 0; $i < count($chars); $i++) {
        $rail = $pattern[$i % count($pattern)];
        $result .= $fence[$rail][$i];
    }
    return $result;
}
