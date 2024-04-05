<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

function calculate(string $input): int
{
    $stringOperations = ['plus', 'minus', 'multiplied', 'divided'];
    $operators = [];
    $numbers = [];

    $input = preg_replace('/[^A-Za-z0-9\-]/', ' ', $input);
    $input = trim($input);
    echo $input . "<br>";
    $input = explode(" ", $input);
    print_r($input);
    $inputCount = count($input);
    for ($i = 0; $i < $inputCount; $i++) {
        $str = $input[$i];
        if (in_array($str, $stringOperations)) {
            switch ($str) {
                case 'plus':
                    array_push($operators, "+");
                    break;
                case 'minus':
                    array_push($operators, "-");
                    break;
                case 'multiplied':
                    array_push($operators, "*");
                    break;
                case 'divided':
                    array_push($operators, "/");
                    break;
                default:
                    echo 'Palabra o número que no es operador.<br>';
                    break;
            }
        } elseif (is_numeric($str)) {
            array_push($numbers, intval($str));
        } else {
            echo 'The word is neither an operation nor a number.<br>';
        }
    }

    if (empty($operators) || empty($numbers)) {
        throw new \InvalidArgumentException('No operators or numbers to calculate.');
    }

    $result = array_shift($numbers);
    while (!empty($numbers)) {
        $operator = array_shift($operators);
        $number2 = array_shift($numbers);
        switch ($operator) {
            case '+':
                $result +=  $number2;
                break;
            case '-':
                $result -= $number2;
                break;
            case '*':
                $result *= $number2;
                break;
            case '/':
                $result /= $number2;
                break;
        }
    }

    return $result;
}
