<?php

/*
Instructions
Given the position of two queens on a chess board, indicate whether or not they are positioned so that they can attack each other.

In the game of chess, a queen can attack pieces which are on the same row, column, or diagonal.

A chessboard can be represented by an 8 by 8 array.

So if you're told the white queen is at (2, 3) and the black queen at (5, 6), then you'd know you've got a set-up like so:

_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ W _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ B _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
You'd also be able to answer whether the queens can attack each other. In this case, that answer would be yes, they can, because both pieces share a diagonal.
 */

declare(strict_types=1);

function placeQueen(int $xCoordinate, int $yCoordinate): bool
{
    if ($xCoordinate < 0 || $yCoordinate < 0) {
        throw new \InvalidArgumentException('The rank and file numbers must be positive.');
    }
    if ($xCoordinate >= 8 || $yCoordinate >= 8) {
        throw new \InvalidArgumentException('The position must be on a standard size chess board.');
    }
    return true;
}

function canAttack(array $whiteQueen, array $blackQueen): bool
{
    $whiteQueenX = $whiteQueen[1];
    $whiteQueenY = $whiteQueen[0];
    $blackQueenX = $blackQueen[1];
    $blackQueenY = $blackQueen[0];

    $inBoard = fn ($x, $y) => $x >= 0 && $x < 8 && $y >= 0 && $y < 8;

    $diagonalDirections = [
        [-1, -1], [-1, 1], [1, -1], [1, 1]
    ];

    // Check every diagonal direction
    foreach ($diagonalDirections as list($dx, $dy)) {
        $x = $whiteQueenX + $dx;
        $y = $whiteQueenY + $dy;
        while ($inBoard($x, $y)) {
            if ($x === $blackQueenX && $y === $blackQueenY) {
                return true;
            }
            $x += $dx;
            $y += $dy;
        }
    }

    // Check row and column
    if ($whiteQueenY === $blackQueenY || $whiteQueenX === $blackQueenX) {
        return true;
    }

    return false;
}
