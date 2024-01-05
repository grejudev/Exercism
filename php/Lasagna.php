<?php

declare(strict_types=1);

class Lasagna
{
    // Please define the 'expectedCookTime()' function
    function expectedcookTime()
    {
        return 40;
    }

    // Please define the 'remainingCookTime($elapsed_minutes)' function
    function remainingCookTime($elapsed_minutes)
    {
        return 40 - $elapsed_minutes;
    }

    // Please define the 'totalPreparationTime($layers_to_prep)' function
    function totalPreparationTime($layers_to_prep)
    {
        return $layers_to_prep * 2;
    }

    // Please define the 'totalElapsedTime($layers_to_prep, $elapsed_minutes)' function
    function totalElapsedTime($layers_to_prep, $elapsed_minutes)
    {
        return ($layers_to_prep * 2) + $elapsed_minutes;
    }

    // Please define the 'alarm()' function
    function alarm()
    {
        return 'Ding!';
    }
}
