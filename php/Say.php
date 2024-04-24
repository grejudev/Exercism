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

// Main function to convert a number into words
function say(int $number): string
{
    // Validation for input number range
    if ($number < 0 || $number > 999999999999) {
        throw new \InvalidArgumentException("Input out of range");
    }
    // Special case for number 0
    if ($number === 0) {
        return "zero";
    }

    // Variable to store the final result
    $result = "";

    // Convert the number into an array of digits
    $array_numbers = str_split(strval($number));

    // Divide the array of digits into groups of three
    $chunks = custom_array_chunk($array_numbers);

    // Scales for groups of three digits
    $scale_words = ["", " thousand ", " million ", " billion ", " trillion "];

    // Index of the current scale
    $scale = count($chunks) - 1;

    // Iterate over each group of digits
    foreach ($chunks as $chunk) {
        // Convert the group of digits into an integer
        $chunk_number = intval(implode("", $chunk));
        // If the group number is 0, move to the next group
        if ($chunk_number === 0) {
            continue;
        }
        $length = strlen(strval($chunk_number));

        // Translate the group of digits into words based on its length
        $result .= match ($length) {
            0 => "",
            1, 2 => range0to99($chunk_number),
            3 => range100to999($chunk_number),
        };
        // Add the corresponding scale to the result
        $result .= $scale_words[$scale];

        // Decrease the scale index
        $scale--;
    }

    // Remove any trailing whitespace and return the result
    return trim($result);
}

function range0to99($num): string
{
    // Validation for number range
    if ($num < 0 || $num > 99) {
        throw new \InvalidArgumentException("Input must be between 0 and 99");
    }

    // Length of the number
    $length = strlen(strval($num));

    // Translate the two-digit number into words based on its value
    if ($length === 1 && ($word = singleDigit($num)) !== null) {
        return $word;
    } elseif ($length === 2 && ($word = doubleDigit($num)) !== null) {
        return $word;
    } else {
        // Get the tens and units of the number
        $tens = doubleDigit(intval(substr(strval($num), 0, 1) . "0"));
        $units = singleDigit(intval(substr(strval($num), 1, 1)));
        return $tens . "-" . $units;
    }
}

// Function to translate a single-digit number into words
function singleDigit($num): ?string
{
    return match ($num) {
        1 => "one",
        2 => "two",
        3 => "three",
        4 => "four",
        5 => "five",
        6 => "six",
        7 => "seven",
        8 => "eight",
        9 => "nine",
        default => null
    };
}

// Function to translate a double-digit number into words
function doubleDigit($num): ?string
{
    return match ($num) {
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
        40 => "forty",
        50 => "fifty",
        60 => "sixty",
        70 => "seventy",
        80 => "eighty",
        90 => "ninety",
        default => null,
    };
}

// Function to translate a three-digit number into words
function range100to999($num): ?string
{
    // Validation for number range
    if ($num < 100 || $num > 999) {
        throw new \InvalidArgumentException("Input must be between 100 and 999");
    }

    // Get the digit of the hundreds
    $num_hundreds = intval(substr(strval($num), 0, 1));

    // Translate the hundreds into words
    $hundreds = singleDigit($num_hundreds);

    // Variable to store the result of the hundreds
    $str = "";

    // Indicates if the "hundred" word has been added to the result
    $hundredAdded = false;

    // Add the hundreds to the result if not zero
    if ($num_hundreds !== 0) {
        $str = $hundreds . " hundred";
        $hundredAdded = true;
    }

    // Get the remainder of the number without the hundreds
    $remainder = intval(substr(strval($num), 1, 2));

    // Add the tens and units to the result if not zero
    if ($remainder !== 0) {
        if ($hundredAdded) {
            $str .= " " . range0to99($remainder);
        } else {
            $str = range0to99($remainder);
        }
    }

    return $str;
}

// Function to split an array into groups of three elements
function custom_array_chunk($array)
{
    $first_chunk_size = count($array) % 3;
    $first_chunk_size = $first_chunk_size == 0 ? 3 : $first_chunk_size;

    $first_chunk = array_slice($array, 0, $first_chunk_size);
    $chunks = array_chunk(array_slice($array, $first_chunk_size), 3);
    array_unshift($chunks, $first_chunk);

    return $chunks;
}

