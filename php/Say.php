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
    if ($number < 0 || $number > 999999999999) {
        throw new \InvalidArgumentException("Input out of range");
    }

    $result = "";
    $array_numbers = str_split(strval($number));
    $chunks = custom_array_chunk($array_numbers);
    $scale_words = ["", " thousand ", " million ", " billion ", " trillion "];
    $scale = count($chunks) - 1;
    foreach ($chunks as $chunk) {
        $length = count($chunk);
        match ($length) {
            0 => $result = $result . "",
            1, 2 => $result = $result . range0to99(intval(implode("", $chunk)), $result),
            3 => $result = $result . range100to999(intval(implode("", $chunk)), $result),
        };
        $result .= $scale_words[$scale];
        $scale--;
    }


    return $result;
}

function range0to99($num): ?string
{
    $str = "";
    if ($num < 0 || $num > 99) {
        throw new \InvalidArgumentException("Input must be between 0 and 99");
    }

    $length = strlen(strval($num));
    if ($length === 1 && singleDigit($num) !== null) {
        $str = $str . singleDigit($num);
        return $str;
    } elseif ($length === 2 && doubleDigit($num) !== null) {
        $str = $str . doubleDigit($num);
        return $str;
    } else {
        // Take first digit with followed by a 0 to know tens
        $tens = doubleDigit(intval(substr(strval($num), 0, 1) . "0"));
        // Take second digit to know units
        $units = singleDigit(intval(substr(strval($num), 1, 1)));
        $str = $str . $tens . "-" . $units;
        return $str;
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
        50 => "fifty",
        60 => "sixty",
        70 => "seventy",
        80 => "eighty",
        90 => "ninety",
        default => null,
    };
    return $doubleDigit;
}

function range100to999($num): ?string
{
    $str = "";
    if ($num < 100 || $num > 999) {
        throw new \InvalidArgumentException("Input must be between 0 and 99");
    }
    $num_hundreds = intval(substr(strval($num), 0, 1));
    $hundreds = singleDigit($num_hundreds);
    // Variable to track if "hundred" has been added
    $hundredAdded = false;
    if ($num_hundreds !== 0) {
        $str = $str . $hundreds . " hundred";
        $hundredAdded = true;
    }
    $remainder = intval(substr(strval($num), 1, 2));
    if ($remainder !== 0) {
        if ($hundredAdded) {
            $str = $str . " " . range0to99($remainder, null);
        } else {
            $str = $str . " " . range0to99($remainder, $str);
        }
    }
    return $str;
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
