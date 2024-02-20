<?php


declare(strict_types=1);

class Clock
{

    private $hours = 0;
    private $minutes = 0;
    private $validHours;
    private $validMinutes;


    public function __construct(int $hour, int $minute = null)
    {
        $this->hours = $hour;
        $this->minutes = $minute;
        $this->validHours = range(0, 23);
        $this->validMinutes = range(0, 59);

        // Check if the given hours is in the valid range
        if (!in_array($hour, $this->validHours)) {
            $adjustedHours = ($this->hours % count($this->validHours) + count($this->validHours)) % count($this->validHours);
            $this->hours = $adjustedHours;
        }
        // Check if the given minutes is in the valid range
        if (!in_array($minute, $this->validMinutes)) {
            if ($minute >= 0) {
                $this->addMinutes($minute);
            } else {
                $this->reduceMinutes($minute);
            }
        }
    }

    public function __toString(): string
    {
        return str_pad("" . $this->hours, 2, "0", STR_PAD_LEFT) . ":" . str_pad("" . $this->minutes, 2, "0", STR_PAD_LEFT);
    }

    public function add(int $minutes)
    {
        // If the given minutes are negative
        if ($minutes < 0) {
            return $this->sub(abs($minutes));;
        }
        $totalMinutes = $this->minutes + $minutes;
        return $this->addMinutes($totalMinutes);
    }

    public function sub(int $minutes)
    {
        $totalMinutes = $this->minutes - $minutes;
        return $this->reduceMinutes($totalMinutes);
    }

    public function reduceMinutes(int $m): Clock
    {
        $adjustedMinutes = ($m % count($this->validMinutes) + count($this->validMinutes)) % count($this->validMinutes);
        $this->minutes = abs($adjustedMinutes);

        // Calculates reduced hours and updates minutes and hours
        $reducedHours = intdiv($m, count($this->validMinutes)) - 1;
        $totalHours = $this->hours - abs($reducedHours);
        // Adjust the hours using the modulo operator
        $adjustedHours = ($totalHours % count($this->validHours) + count($this->validHours)) % count($this->validHours);
        $this->hours = $adjustedHours;

        return $this;
    }

    public function addMinutes(int $m): Clock
    {
        $adjustedMinutes = $m % count($this->validMinutes);
        $this->minutes = $adjustedMinutes;

        // Calculates additional hours and updates minutes and hours
        $additionalHours = intdiv($m, count($this->validMinutes));
        $totalHours = $this->hours + $additionalHours;
        // Adjust the hours using the modulo operator
        $adjustedHours = $totalHours % count($this->validHours);
        $this->hours = $adjustedHours;

        return $this;
    }
}

// 1st Test
$clock = new Clock(3, -20);
// $clock = $clock->sub(60);
echo '<pre>';
echo $clock->__toString();
echo '</pre>';
