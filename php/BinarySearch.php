<?php

/*
Instructions
Your task is to implement a binary search algorithm.

A binary search algorithm finds an item in a list by repeatedly splitting it in half, only keeping the half which contains the item we're looking for. It allows us to quickly narrow down the possible locations of our item until we find it, or until we've eliminated all possible locations.

Caution
Binary search only works when a list has been sorted.

The algorithm looks like this:

Find the middle element of a sorted list and compare it with the item we're looking for.
If the middle element is our item, then we're done!
If the middle element is greater than our item, we can eliminate that element and all the elements after it.
If the middle element is less than our item, we can eliminate that element and all the elements before it.
If every element of the list has been eliminated then the item is not in the list.
Otherwise, repeat the process on the part of the list that has not been eliminated.
Here's an example:

Let's say we're looking for the number 23 in the following sorted list: [4, 8, 12, 16, 23, 28, 32].

We start by comparing 23 with the middle element, 16.
Since 23 is greater than 16, we can eliminate the left half of the list, leaving us with [23, 28, 32].
We then compare 23 with the new middle element, 28.
Since 23 is less than 28, we can eliminate the right half of the list: [23].
We've found our item.
How to debug
When a test fails, a message is displayed describing what went wrong and for which input.

Printing values and contents of variables can also help with understanding what happens. PHP can print values using:

echo 'Debug message'; to output a string of your choice
var_dump($variable); to get more insight into a value, e.g. the type PHP sees
 */

declare(strict_types=1);

function find(int $needle, array $haystack): int
{
    $low = 0;
    $high = count($haystack) - 1;

    while ($low <= $high) {
        $mid = intval(floor(($low + $high) / 2));
        $guess = $haystack[$mid];

        if ($guess === $needle) {
            return $mid;
        } elseif ($guess < $needle) {
            $low = $mid + 1;
        } else {
            $high = $mid - 1;
        }
    }

    return -1;
}
