<?php

declare(strict_types=1);
function resultFor(array $lines)
{
    $board = array_map('str_split', $lines);
    if (connect($board, 'X')) {
        return 'black';
    }
    if (connect(oBoard($board), 'O')) {
        return 'white';
    }
    return null;
}
function connect(array $board, string $stone)
{
    for ($i = 0; $i < count($board); $i++) {
        if ($board[$i][0] === $stone && stoneIsConnected([0, $i], $board, $stone)) {
            return true;
        }
    }
}
function stoneIsConnected(array $point, array $board, $stone)
{
    $adjacents = [[0, -1], [1, -1], [1, 0], [-1, 0], [-1, 1], [0, 1]];

    $lineLength = count($board[0]) - 1;
    $connected = [$point];

    while (count($connected) > 0) {
        $point = array_shift($connected);
        $board[$point[1]][$point[0]] = ' ';

        if ($point[0] === $lineLength) {
            return true;
        }
        foreach ($adjacents as [$x, $y]) {
            if (
                !empty($board[$point[1] + $y])
                && !empty($board[$point[1] + $y][$point[0] + $x])
                && $board[$point[1] + $y][$point[0] + $x] === $stone
            ) {
                $connected[] = [($point[0] + $x), ($point[1] + $y)];
            }
        }
    }
    return false;
}
function oBoard($board)
{
    $oBoard = [];
    for ($x = 0; $x < count($board[0]); $x++) {
        $line = [];
        for ($y = 0; $y < count($board); $y++) {
            $line[] = $board[$y][$x];
        }
        $oBoard[] = $line;
    }
    return $oBoard;
}
