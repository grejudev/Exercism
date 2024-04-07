<?php

/*
Instructions
Take a nested list and return a single flattened list with all values except nil/null.

The challenge is to write a function that accepts an arbitrarily-deep nested list-like structure and returns a flattened structure without any nil/null values.

For Example

input: [1,[2,3,null,4],[null],5]

output: [1,2,3,4,5]
 */

declare(strict_types=1);

function flatten(array $input): array
{
    $lst = array();
    foreach (array_keys($input) as $k) {
        $v = $input[$k];
        if (is_scalar($v)) {
            $lst[] = $v;
        } elseif (is_array($v)) {
            $lst = array_merge(
                $lst,
                flatten($v)
            );
        }
    }
    return $lst;
}
