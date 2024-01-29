<?php

declare(strict_types=1);

class ResistorColorTrio
{

    public function label($arr): string
    {
        $output = "";
        $colors = ["black", "brown", "red", "orange", "yellow", "green", "blue", "violet", "grey", "white"];

        $first_digit = array_search($arr[0], $colors);
        $second_digit = array_search($arr[1], $colors);
        $number_zeros = array_search($arr[2], $colors);

        $value = ($first_digit * 10 + $second_digit) * (10 ** $number_zeros);

        $units = ["ohms", "kiloohms", "megaohms", "gigaohms"];
        $unit_index = 0;

        while ($value >= 1000 && $unit_index < count($units) - 1) {
            $value /= 1000;
            $unit_index++;
        }

        $output = round($value, 2) . ' ' . $units[$unit_index];

        return $output;
    }
}



$instance = new ResistorColorTrio();
$result = $instance->label(['red', 'black', 'red']);
echo $result;
