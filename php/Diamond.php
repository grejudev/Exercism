<?php

declare(strict_types=1);

function diamond(string $letter): array
{
    $alphabet = range("A", "Z");
    $index = array_search($letter, $alphabet);

    $diagonalLength = ($index * 2 - 1) + 2;
    $diagonal = $index > 0 ? $letter . str_repeat(" ", ($index * 2 - 1)) . $letter : $letter;

    $arr = [];
    // First n/2 - 1 elements of the diamond 
    for ($i = 0; $i < $diagonalLength / 2 - 1; $i++) {
        $index = array_search($alphabet[$i], $alphabet);
        if ($i === 0) {
            array_push($arr, str_pad($alphabet[$i], ($diagonalLength), " ", STR_PAD_BOTH));
            continue;
        }
        array_push($arr, str_pad(($alphabet[$i] . str_repeat(" ", ($index * 2 - 1)) . $alphabet[$i]), $diagonalLength, " ", STR_PAD_BOTH));
    }
    $arr_reverse = array_reverse($arr);
    // Diagonal and remaining elements
    array_push($arr, $diagonal, ...$arr_reverse);

    return $arr;
}

echo '<pre>';
print_r(diamond("E"));
echo '</pre>';
