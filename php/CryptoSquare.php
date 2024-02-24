<?php

declare(strict_types=1);

function crypto_square(string $plaintext): string
{
    $plaintext = cleanText($plaintext);
    $plaintextLength = strlen($plaintext);

    $rows = (int)ceil(sqrt($plaintextLength));
    $col = $rows ** 2 - $rows >= $plaintextLength ? $rows - 1 : $rows;

    // Initialize rectangle rows
    $rectangle = array_fill(0, $rows, '');
    // Add letters
    $i = 0;
    for ($y = 0; $y < $col; $y++) {
        for ($x = 0; $x < $rows; $x++) {
            if ($i < $plaintextLength) {
                $letter = $plaintext[$i];
                $rectangle[$x] .= $letter;
                $i++;
            }
        }
    }
    // Fill spaces
    for ($x = 0; $x < $rows; $x++) {
        $rectangle[$x] = str_pad($rectangle[$x], $col, ' ');
    }

    $result = implode(' ', $rectangle);
    return $result;
}

function cleanText($string): string
{
    $string = strtolower(str_replace(' ', '', $string)); // Replaces all spaces with hyphens and lowercase
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

// echo '<pre>';
// print_r(crypto_square("If man was meant to stay on the ground, god would have given us roots."));
// echo '</pre>';
