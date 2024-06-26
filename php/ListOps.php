<?php

/*
* Instructions
* Implement basic list operations.
* 
* In functional languages list operations like length, map, and reduce are very common. Implement a series of basic list operations, without using existing functions.
* 
* The precise number and names of the operations to be implemented will be track dependent to avoid conflicts with existing names, but the general operations you will implement include:
* 
* append (given two lists, add all items in the second list to the end of the first list);
* concatenate (given a series of lists, combine all items in all lists into one flattened list);
* filter (given a predicate and a list, return the list of all items for which predicate(item) is True);
* length (given a list, return the total number of items within it);
* map (given a function and a list, return the list of the results of applying function(item) on all items);
* foldl (given a function, a list, and initial accumulator, fold (reduce) each item into the accumulator from the left);
* foldr (given a function, a list, and an initial accumulator, fold (reduce) each item into the accumulator from the right);
* reverse (given a list, return a list with all the original items, but in reversed order).
* Note, the ordering in which arguments are passed to the fold functions (foldl, foldr) is significant.
* 
* Callable
* In PHP there is a concept of callable.
* 
* Those can take multiple forms, but we will focus on anonymous functions.
* 
* It is possible to create an anonymous function in a variable and call it with parameters:
* 
* $double = function ($number) {
*     return $number * 2;
* }
* 
* $double(2); // returns 4
* $double(4); // returns 8
 */

declare(strict_types=1);

class ListOps
{
    /**
     * Appends the elements of $list2 to $list1.
     */
    public function append(array $list1, array $list2): array
    {
        foreach ($list2 as $value) {
            array_push($list1, $value);
        }
        return $list1;
    }

    public function concat(array $list1, array ...$listn): array
    {
        foreach ($listn as $arr) {
            $list1 = $this->append($list1, $arr);
        }
        return $list1;
    }

    /**
     * @param callable(mixed $item): bool $predicate
     * Filters elements of $list using the $predicate function.
     */
    public function filter(callable $predicate, array $list): array
    {
        $filtered = [];
        foreach ($list as $element) {
            if ($predicate($element) === true) {
                array_push($filtered, $element);
            }
        }
        return $filtered;
    }

    /**
     * Returns the number of elements in the array.
     */
    public function length(array $list): int
    {
        return count($list);
    }

    /**
     * @param callable(mixed $item): mixed $function
     * Applies the $function to each element of the $list.
     */
    public function map(callable $function, array $list): array
    {
        $mapped = [];
        foreach ($list as $element) {
            $mapped[] = $function($element);
        }
        return $mapped;
    }

    /**
     * @param callable(mixed $accumulator, mixed $item): mixed $function
     * Folds (reduces) the array from the left using the $function.
     */
    public function foldl(callable $function, array $list, $accumulator)
    {
        foreach ($list as $element) {
            $accumulator = $function($accumulator, $element);
        }
        return $accumulator;
    }

    /**
     * @param callable(mixed $accumulator, mixed $item): mixed $function
     * Folds (reduces) the array from the right using the $function.
     */
    public function foldr(callable $function, array $list, $accumulator)
    {
        for ($i = count($list) - 1; $i >= 0; $i--) {
            $element = $list[$i];
            $accumulator = $function($accumulator, $element);
        }
        return $accumulator;
    }

    /**
     * Returns a new array with elements in reverse order.
     */
    public function reverse(array $list): array
    {
        $reversed = [];
        for ($i = count($list) - 1; $i >= 0; $i--) {
            $element = $list[$i];
            $reversed[] = $element;
        }
        return $reversed;
    }
}
