<?php

declare(strict_types=1);

function brackets_match(string $input): bool
{
    $combinations = ['[' => ']', '{' => '}', '(' => ')'];
    $stack = [];

    $str_length = strlen($input);

    for ($i = 0; $i < $str_length; $i++) {
        $letter = $input[$i];

        if (array_key_exists($letter, $combinations)) {
            // Es un bracket de apertura, lo agregamos al stack
            array_push($stack, $letter);
        } elseif (in_array($letter, $combinations)) {
            // Es un bracket de cierre
            if (empty($stack) || $combinations[array_pop($stack)] !== $letter) {
                // No hay correspondencia o la correspondencia es incorrecta
                return false;
            }
        }
    }
    // Verificamos si quedaron brackets sin cerrar
    return empty($stack);
}
