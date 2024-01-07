<?php

class PizzaPi
{
    public function calculateDoughRequirement(int $number_pizzas, int $number_persons): int
    {
        $grams = $number_pizzas * (($number_persons * 20) + 200);
        return $grams;
    }

    public function calculateSauceRequirement(int $pizzas, int $can): int
    {
        $sauce_per_pizza = 125;
        $number_cans = $pizzas * $sauce_per_pizza / $can;
        return $number_cans;
    }

    public function calculateCheeseCubeCoverage($cheese_length, $cheese_thickness, $pizza_diameter)
    {
        define("PI", pi());
        $num_pizzas = ($cheese_length ** 3) / ($cheese_thickness * PI * $pizza_diameter);
        return (int) $num_pizzas;
    }

    public function calculateLeftOverSlices(int $num_pizzas, int $num_friends): int
    {
        $totalSlices = $num_pizzas * 8;
        $leftOverSlices = $totalSlices % $num_friends;
        return $leftOverSlices;
    }
}
