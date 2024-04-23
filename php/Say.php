<?php

/*
* Instructions
* Given a number from 0 to 999,999,999,999, spell out that number in English.
* 
*-------- Step 1 --------*
* Handle the basic case of 0 through 99.
* 
* If the input to the program is 22, then the output should be 'twenty-two'.
* 
* Your program should complain loudly if given a number outside the blessed range.
* 
* Some good test cases for this program are:
* 
* 0
* 14
* 50
* 98
* -1
* 100
* Extension
* If you're on a Mac, shell out to Mac OS X's say program to talk out loud. If 
* you're on Linux or Windows, eSpeakNG may be available with the command espeak.
* 
*-------- Step 2 --------*
* Implement breaking a number up into chunks of thousands.
* 
* So 1234567890 should yield a list like 1, 234, 567, and 890, while the far 
* simpler 1000 should yield just 1 and 0.
* 
* The program must also report any values that are out of range.
* 
*-------- Step 3 --------*
* Now handle inserting the appropriate scale word between those chunks.
* 
* So 1234567890 should yield '1 billion 234 million 567 thousand 890'
* 
* The program must also report any values that are out of range. It's fine to 
* stop at "trillion".
* 
*-------- Step 4 --------*
* Put it all together to get nothing but plain English.
* 
* 12345 should give twelve thousand three hundred forty-five.
* 
* The program must also report any values that are out of range.
 */

declare(strict_types=1);

function say(int $number): string
{
    $result = "";
    $length = strlen(strval($number));
    $array_numbers = str_split(strval($number));
    $chunks = custom_array_chunk($array_numbers);
    $scale_words = ["trillion", "billion", "million", "thousand"];
    match ($length) {
        0 => "null",
        1, 2 => $result = $result . range0to99($number, $result),
        3 => $result = $result . range100to999($number, $result),
        4 => "ToBeDone",
        5 => "ToBeDone",
        6 => "ToBeDone",
        7 => "ToBeDone",
        8 => "ToBeDone",
        9 => "ToBeDone",
        10 => "ToBeDone",
        11 => "ToBeDone",
        12 => "ToBeDone",
    };

    return $result;
}

function range0to99($num, $result): ?string
{
    if ($num < 0 || $num > 99) {
        throw new \InvalidArgumentException("Input must be between 0 and 99");
    }

    $length = strlen(strval($num));
    if ($length === 1 && singleDigit($num) !== null) {
        $result = $result . singleDigit($num);
        return $result;
    } elseif ($length === 2 && doubleDigit($num) !== null) {
        $result = $result . doubleDigit($num);
        return $result;
    } else {
        // Take first digit with followed by a 0 to know tens
        $tens = doubleDigit(intval(substr(strval($num), 0, 1) . "0"));
        // Take second digit to know units
        $units = singleDigit(intval(substr(strval($num), 1, 1)));
        $result = $result . $tens . "-" . $units;
        return $result;
    }
    return null;
}

function singleDigit($num): ?string
{
    $singleDigit = match ($num) {
        0 => "zero",
        1 => "one",
        2 => "two",
        3 => "three",
        4 => "four",
        5 => "five",
        6 => "six",
        7 => "seven",
        8 => "eight",
        9 => "nine",
        default => "null"
    };
    return $singleDigit;
}

function doubleDigit($num): ?string
{
    $doubleDigit = match ($num) {
        10 => "ten",
        11 => "eleven",
        12 => "twelve",
        13 => "thirteen",
        14 => "fourteen",
        15 => "fiveteen",
        16 => "sixteen",
        17 => "seventeen",
        18 => "eightteen",
        19 => "nineteen",
        20 => "twenty",
        30 => "thirty",
        40 => "fourty",
        50 => "fivety",
        60 => "sixty",
        70 => "seventy",
        80 => "eightty",
        90 => "ninety",
        default => null,
    };
    return $doubleDigit;
}

function range100to999($num, $result): ?string
{
    if ($num < 100 || $num > 999) {
        throw new \InvalidArgumentException("Input must be between 0 and 99");
    }
    $num_hundreds = intval(substr(strval($num), 0, 1));
    $hundreds = singleDigit($num_hundreds);
    // Variable to track if "hundred" has been added
    $hundredAdded = false;
    if ($num_hundreds !== 0) {
        $result = $result . $hundreds . " hundred";
        $hundredAdded = true;
    }
    $remainder = intval(substr(strval($num), 1, 2));
    if ($remainder !== 0) {
        if ($hundredAdded) {
            $result = $result . " " . range0to99($remainder, null);
        } else {
            $result = $result . " " . range0to99($remainder, $result);
        }
    }
    return $result;
}

function custom_array_chunk($array)
{
    $first_chunk_size = count($array) % 3;
    $first_chunk_size = $first_chunk_size == 0 ? 3 : $first_chunk_size;

    $first_chunk = array_slice($array, 0, $first_chunk_size);
    $chunks = array_chunk(array_slice($array, $first_chunk_size), 3);
    array_unshift($chunks, $first_chunk);

    return $chunks;
}

echo '<pre>';
print_r(say(1234567890));
echo '</pre>';
