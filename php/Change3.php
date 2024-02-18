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

function findFewestCoins($coins, $n)
{
    if ($n == 0) {
        return array();
    }
    if ($n < 0) {
        throw new InvalidArgumentException("Cannot make change for negative value");
    }
    if (min($coins) > $n) {
        throw new InvalidArgumentException("No coins small enough to make change");
    }
    $d = array_fill(0, $n + 1, $n + 1);
    $d[0] = 0;
    for ($i = 1; $i <= $n; $i++) {
        foreach ($coins as $c) {
            if ($i - $c >= 0) {
                $d[$i] = min($d[$i], $d[$i - $c] + 1);
            }
        }
    }
    $changes = array();
    find($n, [], $d, $coins, $changes, 0);
    if (count($changes) == 0) {
        throw new InvalidArgumentException("No combination can add up to target");
    }
    return $changes[0];
}
function find($n, $result, $d, $coins, &$changes, $index)
{
    if ($n == 0) {
        array_push($changes, $result);
        return;
    }
    for ($i = $index; $i < count($coins); $i++) {
        if (($n - $coins[$i] >= 0) && ($d[$n] == ($d[$n - $coins[$i]] + 1))) {
            array_push($result, $coins[$i]);
            find($n - $coins[$i], $result, $d, $coins, $changes, $i);
        }
    }
}
