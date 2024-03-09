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

class SpaceAge
{
    private int $sec;
    private float  $earthSecondsInYear = 365.25 * 24 * 60 * 60;
    private float $orbitalPeriod_Mercury = 0.2408467;
    private float $orbitalPeriod_Venus = 0.61519726;
    private float $orbitalPeriod_Earth = 1.0;
    private float $orbitalPeriod_Mars = 1.8808158;
    private float $orbitalPeriod_Jupiter = 11.862615;
    private float $orbitalPeriod_Saturn = 29.447498;
    private float $orbitalPeriod_Uranus = 84.016846;
    private float $orbitalPeriod_Neptune = 164.79132;

    public function __construct(int $seconds)
    {
        $this->sec = $seconds;
    }

    public function seconds(): int
    {
        return $this->sec;
    }

    public function earth(): float
    {
        return round($this->sec / ($this->orbitalPeriod_Earth * $this->earthSecondsInYear), 2);
    }

    public function mercury(): float
    {
        return round($this->sec / ($this->orbitalPeriod_Mercury * $this->earthSecondsInYear), 2);
    }

    public function venus(): float
    {
        return round($this->sec / ($this->orbitalPeriod_Venus * $this->earthSecondsInYear), 2);
    }

    public function mars(): float
    {
        return round($this->sec / ($this->orbitalPeriod_Mars * $this->earthSecondsInYear), 2);
    }

    public function jupiter(): float
    {
        return round($this->sec / ($this->orbitalPeriod_Jupiter * $this->earthSecondsInYear), 2);
    }

    public function saturn(): float
    {
        return round($this->sec / ($this->orbitalPeriod_Saturn * $this->earthSecondsInYear), 2);
    }

    public function uranus(): float
    {
        return round($this->sec / ($this->orbitalPeriod_Uranus * $this->earthSecondsInYear), 2);
    }

    public function neptune(): float
    {
        return round($this->sec / ($this->orbitalPeriod_Neptune * $this->earthSecondsInYear), 2);
    }
}
