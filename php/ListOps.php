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
    public function append(array $list1, array $list2): array
    {
        throw new \BadMethodCallException("Implement the append function");
    }

    public function concat(array $list1, array ...$listn): array
    {
        throw new \BadMethodCallException("Implement the concat function");
    }

    /**
     * @param callable(mixed $item): bool $predicate
     */
    public function filter(callable $predicate, array $list): array
    {
        throw new \BadMethodCallException("Implement the filter function");
    }

    public function length(array $list): int
    {
        throw new \BadMethodCallException("Implement the length function");
    }

    /**
     * @param callable(mixed $item): mixed $function
     */
    public function map(callable $function, array $list): array
    {
        throw new \BadMethodCallException("Implement the map function");
    }

    /**
     * @param callable(mixed $accumulator, mixed $item): mixed $function
     */
    public function foldl(callable $function, array $list, $accumulator)
    {
        throw new \BadMethodCallException("Implement the foldl function");
    }

    /**
     * @param callable(mixed $accumulator, mixed $item): mixed $function
     */
    public function foldr(callable $function, array $list, $accumulator)
    {
        throw new \BadMethodCallException("Implement the foldr function");
    }

    public function reverse(array $list): array
    {
        throw new \BadMethodCallException("Implement the reverse function");
    }
}
