<?php

// In positional notation, a number in base b can be understood as a linear combination of powers of b.

// The number 42, in base 10, means:
// (4 * 10^1) + (2 * 10^0)

// The number 101010, in base 2, means:
// (1 * 2^5) + (0 * 2^4) + (1 * 2^3) + (0 * 2^2) + (1 * 2^1) + (0 * 2^0)

// The number 1120, in base 3, means:
// (1 * 3^3) + (1 * 3^2) + (2 * 3^1) + (0 * 3^0)

declare(strict_types=1);

function rebase(int $from, array $input, int $to): ?array
{
    if ($from < 2 || $to < 2) {
        return null;
    }
    if (!$input || $input[0] === 0 || min($input) < 0 || max($input) >= $from) {
        return null;
    }
    $base = 0;
    foreach (array_reverse($input) as $key => $value) {
        $base += $value * ($from ** $key);
    }
    while ($base >= $to) {
        $digits[] = $base % $to;
        $base /= $to;
    }
    $digits[] = (int) $base;
    return array_reverse($digits);
}
