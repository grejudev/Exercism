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
const LAST_FRAME = 10;
const MAX_SCORE = 10;
class Game
{
    public function __construct(private array $pins = [])
    {
    }
    public function score(): int
    {
        if (count($this->pins) === 0) {
            throw new Exception();
        }
        $scores = $current = 0;
        for ($frame = 1; $current < count($this->pins) && $frame <= LAST_FRAME; $frame++) {
            if (!$this->isValidFrame($frame, $current)) {
                throw new Exception();
            }
            $strikeOrSpare = $this->isStrike($current) || $this->isSpare($current);
            $scores += $this->sum($current, 2 + ($strikeOrSpare ? 1 : 0));
            $current += $this->isStrike($current) ? 1 : 2;
        }
        if ($frame <= LAST_FRAME) {
            throw new Exception();
        }
        return $scores;
    }
    private function isValidFrame(int $frame, int $current): bool
    {
        if (count($this->pins) - $current < 1) {
            return false;
        }
        if (!$this->isStrike($current) && $this->sum($current, 2) > 10) {
            return false;
        }
        if ($frame === LAST_FRAME) {
            $strikeOrSpare = $this->isStrike($current) || $this->isSpare($current);
            if (count($this->pins) - $current !== 2 + ($strikeOrSpare ? 1 : 0)) {
                return false;
            }
            if (
                $this->isStrike($current) &&
                !$this->isStrike($current + 1) &&
                $this->sum($current + 1, 2) > MAX_SCORE
            ) {
                return false;
            }
        }
        return true;
    }
    private function isStrike(int $current): bool
    {
        return $this->pins[$current] === MAX_SCORE;
    }
    private function isSpare(int $current): bool
    {
        return $this->sum($current, 2) === MAX_SCORE;
    }
    private function sum(int $current, int $rolls): int
    {
        return array_sum(array_slice($this->pins, $current, $rolls));
    }
    public function roll(int $pins): void
    {
        if ($pins < 0 || $pins > MAX_SCORE) {
            throw new Exception();
        }
        $this->pins[] = $pins;
    }
}
