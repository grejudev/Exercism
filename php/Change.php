<?php
/*
Instructions
Correctly determine the fewest number of coins to be given to a customer such that the sum of the coins' value would equal the correct amount of change.

For example
An input of 15 with [1, 5, 10, 25, 100] should return one nickel (5) and one dime (10) or [5, 10]
An input of 40 with [1, 5, 10, 25, 100] should return one nickel (5) and one dime (10) and one quarter (25) or [5, 10, 25]
Edge cases
Does your algorithm work for any given set of coins?
Can you ask for negative change?
Can you ask for a change value smaller than the smallest coin value?
*/

declare(strict_types=1);

function findFewestCoins(array $coins, int $amount): array
{
    $bestCoinSegment = [];
    $coinsReversed = array_reverse($coins);

    $remainingMoney = $amount;
    $bestNumberCoins = INF;
    $numberCoins = 0;

    $provisionalCoinSegment = [];
    $coinsProved = [];
    foreach ($coinsReversed as  $coinToProve) {
        $continueOuterLoop = false;

        // Check if coins checked are divisible for the next ones
        foreach ($coinsProved as $coinProved) {
            // If coin is divisible by other coins checked
            if ($coinProved % $coinToProve === 0) {
                $continueOuterLoop = true;
                break;
            }
        }
        if ($continueOuterLoop) {
            continue;
        }

        // Find out best combination for available coins
        foreach ($coinsReversed as $coin) {
            if ($coin === $remainingMoney) {
                array_push($provisionalCoinSegment, $coin);
                $remainingMoney -= $coin;
                $numberCoins++;
            } elseif ($coin > $remainingMoney) {
                continue;
            } else {
                while ($remainingMoney - $coin >= 0) {
                    array_push($provisionalCoinSegment, $coin);
                    $remainingMoney -= $coin;
                    $numberCoins++;
                }
            }
        }
        // Is there 
        if ($numberCoins < $bestNumberCoins) {
            $bestNumberCoins = $numberCoins;
            $bestCoinSegment = $provisionalCoinSegment;
        }
        array_push($coinsProved, $coinToProve);
        $numberCoins = 0;
        $provisionalCoinSegment = [];
        array_shift($coinsReversed);
        $remainingMoney = $amount;
    }


    return array_reverse($bestCoinSegment);
}

// echo '<pre>';
// print_r(findFewestCoins([1, 5, 10, 25, 100], 15));
// echo "<br>";

// echo '<pre>';
// print_r(findFewestCoins([1, 5, 10, 25, 100], 25));
// echo "<br>";

// echo '<pre>';
// print_r(findFewestCoins([4, 5], 27));
// echo "<br>";
