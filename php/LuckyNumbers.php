<?php

class LuckyNumbers
{
    public function sumUp(array $digitsOfNumber1, array $digitsOfNumber2): int
    {
        $num1 = implode('', $digitsOfNumber1);
        $num2 = implode('', $digitsOfNumber2);;

        return $num1 + $num2;
    }

    public function isPalindrome(int $number): bool
    {
        return $number == strrev($number);
    }

    public function validate(string $input): string
    {
        $input = trim($input);
        if (empty($input) && $input !== "0") {
            return "Required field";
        }
        $int = (int) ($input);
        if ($int < 1) {
            return "Must be a whole number larger than 0";
        }
        return "";
    }
}
