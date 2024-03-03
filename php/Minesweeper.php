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

function solve(string $minesweeperBoard): string
{
    preg_match('/(-+)/', $minesweeperBoard, $hyphens);
    $width = strlen($hyphens[0]);
    preg_match_all('/(\|+)/', $minesweeperBoard, $pipes);
    $number_pipes = count($pipes[0]);

    $board = trim($minesweeperBoard);
    $lines = explode("\n", $board);
    $lines = array_map('rtrim', array_filter($lines));

    // Check structure
    if ($width < 2 || $number_pipes % 2 !== 0) {
        throw new InvalidArgumentException("Invalid Minesweeper board structure", 1);
    }

    $mineArray = [];

    foreach ($lines as $lineIndex => $line) {
        // Check board is valid
        if ($lines[0][0] !== '+' || $lines[count($lines) - 1][0] !== '+' || $lines[0][strlen($line) - 1] !== '+' || $lines[count($lines) - 1][strlen($line) - 1] !== '+') {
            throw new InvalidArgumentException("Missing character +", 1);
        }
        // Check board's structure
        $borderPattern = '/^\+[+-]+\+$/';
        if (!preg_match($borderPattern, trim($lines[0])) || !preg_match($borderPattern, trim($lines[count($lines) - 1]))) {
            throw new InvalidArgumentException("Invalid Minesweeper board structure");
        }

        $allowedChars = ['+', '-', '|', '*', ' '];
        $rowArray = [];
        for ($i = 0; $i < strlen($line); $i++) {
            // Check characters in board
            if (!in_array($line[$i], $allowedChars)) {
                throw new InvalidArgumentException("Ivalid character found", 1);
            }
            $rowArray[] = $line[$i];
        }
        $mineArray[] = $rowArray;
    }

    for ($row = 1; $row < count($mineArray) - 1; $row++) {
        for ($col = 1; $col < count($mineArray[$row]) - 1; $col++) {

            if ($mineArray[$row][$col] !== '*') {
                $mineCount = 0;

                // Check adjacents
                for ($i = $row - 1; $i <= $row + 1; $i++) {
                    for ($j = $col - 1; $j <= $col + 1; $j++) {
                        if ($mineArray[$i][$j] === '*') {
                            $mineCount++;
                        }
                    }
                }

                $mineArray[$row][$col] = ($mineCount > 0) ? (string) $mineCount : ' ';
            }
        }
    }

    $result = "\n" . implode("\n", array_map('implode', $mineArray)) . "\n";

    return $result;
}


$fourMines = '
+-----+
| * * |
|  *  |
|  *  |
|     |
+-----+
';

$expected = '
+-----+
|1*3*1|
|13*31|
| 2*2 |
| 111 |
+-----+
';

echo '<pre>';
print_r(solve($fourMines));
echo '</pre>';
