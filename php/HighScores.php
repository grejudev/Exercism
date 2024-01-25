<?php

declare(strict_types=1);

class HighScores
{
    public array $scores = [];
    public  $latest = 0;
    public  $personalBest = 0;
    public  $personalTopThree = [];

    public function __construct(array $scores)
    {
        $this->scores = $scores;
        $this->latest = $this->latest($scores);
        $this->personalBest = $this->personalBest($scores);
        $this->personalTopThree = $this->personalTopThree($scores);
    }

    function latest(array $scores)
    {

        return array_pop($scores);
    }

    function personalBest(array $scores)
    {
        return max($scores);
    }

    function personalTopThree(array $scores)
    {
        $topThree = [];
        rsort($scores);
        $topThree = array_slice($scores, 0, 3);

        return $topThree;
    }
}
