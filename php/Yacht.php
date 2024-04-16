<?php

/*
Instructions
The dice game Yacht is from the same family as Poker Dice, Generala and particularly Yahtzee, of which it is a precursor. In the game, five dice are rolled and the result can be entered in any of twelve categories. The score of a throw of the dice depends on category chosen.

Scores in Yacht
+-----------------+------------------------+------------------------------------------+---------------------+
| Category        | Score                  | Description                              | Example             |
+-----------------+------------------------+------------------------------------------+---------------------+
| Ones            | 1 × number of ones     | Any combination                          | 1 1 1 4 5 scores 3  |
+-----------------+------------------------+------------------------------------------+---------------------+
| Twos            | 2 × number of twos     | Any combination                          | 2 2 3 4 5 scores 4  |
+-----------------+------------------------+------------------------------------------+---------------------+
| Threes          | 3 × number of threes   | Any combination                          | 3 3 3 3 3 scores 15 |
+-----------------+------------------------+------------------------------------------+---------------------+
| Fours           | 4 × number of fours    | Any combination                          | 1 2 3 3 5 scores 0  |
+-----------------+------------------------+------------------------------------------+---------------------+
| Fives           | 5 × number of fives    | Any combination                          | 5 1 5 2 5 scores 15 |
+-----------------+------------------------+------------------------------------------+---------------------+
| Sixes           | 6 × number of sixes    | Any combination                          | 2 3 4 5 6 scores 6  |
+-----------------+------------------------+------------------------------------------+---------------------+
| Full House      | Total of the dice      | Three of one number and two of another   | 3 3 3 5 5 scores 19 |
+-----------------+------------------------+------------------------------------------+---------------------+
| Four of a Kind  | Total of the four dice | At least four dice showing the same face | 4 4 4 4 6 scores 16 |
+-----------------+------------------------+------------------------------------------+---------------------+
| Little Straight | 30 points              | 1-2-3-4-5                                | 1 2 3 4 5 scores 30 |
+-----------------+------------------------+------------------------------------------+---------------------+
| Big Straight    | 30 points              | 2-3-4-5-6                                | 2 3 4 5 6 scores 30 |
+-----------------+------------------------+------------------------------------------+---------------------+
| Choice          | Sum of the dice        | Any combination                          | 2 3 3 4 6 scores 18 |
+-----------------+------------------------+------------------------------------------+---------------------+
| Yacht           | 50 points              | All five dice showing the same face      | 4 4 4 4 4 scores 50 |
+-----------------+------------------------+------------------------------------------+---------------------+

Task
Given a list of values for five dice and a category, your solution should return the score of the dice for that category. If the dice do not satisfy the requirements of the category your solution should return 0. You can assume that five values will always be presented, and the value of each will be between one and six inclusively. You should not assume that the dice are ordered.
 */

declare(strict_types=1);

class Yacht
{
    public function score(array $rolls, string $category): int
    {
        if (empty($rolls)) {
            throw new InvalidArgumentException("No se proporcionaron lanzamientos de dados.");
        }

        if (!in_array($category, ['yacht', 'ones', 'twos', 'threes', 'fours', 'fives', 'sixes', 'full house', 'four of a kind', 'little straight', 'big straight'])) {
            throw new InvalidArgumentException("La categoría proporcionada no es válida.");
        }
        
        if ($category == 'full house') {
            $category = 'fullHouse';
        }
        if ($category == 'four of a kind') {
            $category = 'fourOfAKind';
        }
        if ($category == 'little straight') {
            $category = 'littleStraight';
        }
        if ($category == 'big straight') {
            $category = 'bigStraight';
        }

        $score = $this->$category($rolls);

        return $score;
    }

    private function isStraight(array $rolls, int $start, int $end): bool
    {
        $straight = true;
        sort($rolls);
        $min = min($rolls);
        $max = max($rolls);
        for ($i = 0; $i < count($rolls) - 1; $i++) {
            $current = $rolls[$i];
            $next = $rolls[$i + 1];

            // Check if it is Straight
            if ($next !== $current + 1) {
                $straight = false; // Not a Straight
                break;
            }
        }
        if ($straight && $min == $start && $max == $end) {
            return true;
        }
        return false;
    }

    private function littleStraight(array $rolls): int
    {
        return $this->isStraight($rolls, 1, 5) ? 30 : 0;
    }

    private function bigStraight(array $rolls): int
    {
        return $this->isStraight($rolls, 2, 6) ? 30 : 0;
    }

    private function fourOfAKind($rolls): int
    {
        $count_values = array_count_values($rolls);
        if (in_array(4, $count_values) || in_array(5, $count_values)) {
            foreach ($count_values as $number => $count) {
                if ($count === 4 || $count === 5) {
                    return $number * 4;
                }
            };
        }
        return 0;
    }

    private function fullHouse($rolls): int
    {
        $count_values = array_count_values($rolls);
        if (in_array(3, $count_values) && in_array(2, $count_values)) {
            return array_sum($rolls);
        }
        return 0;
    }

    private function yacht($rolls): int
    {
        $target = $rolls[0];
        $count_values = array_count_values($rolls);
        if ($count_values[$target] === 5) {
            return 50;
        }
        return 0;
    }

    private function ones(array $rolls): int
    {
        return $this->numberOfTarget("1", $rolls);
    }
    private function twos(array $rolls): int
    {
        return $this->numberOfTarget("2", $rolls);
    }
    private function threes(array $rolls): int
    {
        return $this->numberOfTarget("3", $rolls);
    }
    private function fours(array $rolls): int
    {
        return $this->numberOfTarget("4", $rolls);
    }
    private function fives(array $rolls): int
    {
        return $this->numberOfTarget("5", $rolls);
    }
    private function sixes(array $rolls): int
    {
        return $this->numberOfTarget("6", $rolls);
    }

    private function numberOfTarget(string $target, array $rolls): int
    {
        $times = 0;
        foreach ($rolls as $value) {
            if ($target === strval($value)) {
                $times++;
            }
        }
        return $target * $times;
    }
}

$yatch = new Yacht();
$yatch->score([1, 5, 2, 3, 4], 'little straight');
