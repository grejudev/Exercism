<?php

// In positional notation, a number in base b can be understood as a linear combination of powers of b.

// The number 42, in base 10, means:
// (4 * 10^1) + (2 * 10^0)

// The number 101010, in base 2, means:
// (1 * 2^5) + (0 * 2^4) + (1 * 2^3) + (0 * 2^2) + (1 * 2^1) + (0 * 2^0)

// The number 1120, in base 3, means:
// (1 * 3^3) + (1 * 3^2) + (2 * 3^1) + (0 * 3^0)

declare(strict_types=1);

function rebase(int $a, array $sequence, int $b)
{

    $sequence_length = count($sequence);

    // Verificar si los parámetros son válidos
    if ($a < 2 || $b < 2 || $sequence_length == 0 || allZeroes($sequence) === true || ($sequence[0] === 0 && $sequence[$sequence_length - 1] === 0)) {
        return null;
    }

    // Verificar si la secuencia contiene dígitos inválidos
    foreach ($sequence as $d) {
        if ($d < 0 || $d >= $a) {
            return null;
        }
    }

    $digit = 0;
    for ($exp = $sequence_length - 1, $i = 0; $exp >= 0; $exp--, $i++) {
        $digit += $sequence[$i] * pow($a, $exp);
    }

    // Convertir el valor decimal a la base deseada
    $resultSequence = [];
    while ($digit > 0) {
        $remainder = $digit % $b;
        array_unshift($resultSequence, $remainder);
        $digit = (int)($digit / $b);
    }

    // Manejar el caso especial de la secuencia vacía
    if (empty($resultSequence)) {
        $resultSequence = [0];
    }

    return $resultSequence;
}

function allZeroes($arr)
{
    foreach ($arr as $v) {
        if ($v != 0) return false;
    }
    return true;
}


// echo '<pre>';
// print_r(rebase(2, [1, 0, 1], 10));
// echo '</pre>';

// echo '<pre>';
// print_r(rebase(10, [5], 2));
// echo '</pre>';
