<?php

/*
For example we can represent the original 53 characters with only 13.
"WWWWWWWWWWWWBWWWWWWWWWWWWBBBWWWWWWWWWWWWWWWWWWWWWWWWB"  ->  "12WB12W3B24WB"

RLE allows the original data to be perfectly reconstructed from the compressed data, which makes it a lossless data compression.
"AABCCCDEEEE"  ->  "2AB3CD4E"  ->  "AABCCCDEEEE"
*/

declare(strict_types=1);

function encode(string $input): string
{
    $output = "";
    if ($input === "") {
        return $input;
    }


    $chars = str_split($input);

    $timesToPrint = 1;
    $str_length = count($chars);
    for ($i = 1; $i < $str_length; $i++) {

        // Letter is not equal to the previous one
        if ($chars[$i] !== $chars[$i - 1]) {
            // Print number + letter or just letter if timesPrinted is equal to 1
            $output .= ($timesToPrint !== 1) ? $timesToPrint . $chars[$i - 1] : $chars[$i - 1];
            $timesToPrint = 1;
            // If "i" is last item, print
            if ($i === count($chars) - 1) {
                $output .= ($timesToPrint !== 1) ? $timesToPrint . $chars[$i] : $chars[$i];
            }
            // Letter is equal to the previous one
        } else {
            $timesToPrint++;
            // If "i" is last item, print
            if ($i === count($chars) - 1) {
                $output .= ($timesToPrint !== 1) ? $timesToPrint . $chars[$i] : $chars[$i];
            }
        }
    }

    return $output;
}

function decode(string $input): string
{
    $output = "";

    $chars = str_split($input);

    $str_length = count($chars);
    for ($i = 0; $i < $str_length; $i++) {

        if (is_numeric($chars[$i])) {
            $number = "";
            $index = "";

            // Find number: Repeat until there isn't a number
            do {
                $number .= $chars[$i];
                $index = $i++;
            } while (is_numeric($chars[$i]) === true);

            $output .= str_repeat($chars[$index + 1], (int)$number); // Repeat letter next to the number

        } else {
            $output .= $chars[$i];
        }
    }

    return $output;
}

// $input = "x";
// $result = encode($input);
// echo '<pre>';
// echo $result;
// echo '</pre>';

// $input2 = "2 hs2q q2w2 ";
// $result2 = decode($input2);
// echo '<pre>';
// echo $result2;
// echo '</pre>';

// $result = decode(encode('zzz ZZ  zZ'));
// echo '<pre>';
// echo $result;
// echo '</pre>';
