<?php


declare(strict_types=1);

class Clock
{
    private $hour = 0;
    private $minute = 0;
    public function __construct(int $hr = 0, int $min = 0)
    {
        $this->hour = $hr;
        $this->minute = $min;
        $this->setTime();
    }
    public function __toString()
    {
        return str_pad("" . $this->hour, 2, "0", STR_PAD_LEFT) . ":" . str_pad("" . $this->minute, 2, "0", STR_PAD_LEFT);
    }
    public function add($min)
    {
        $this->minute += $min;
        $this->setTime();
        return $this;
    }
    public function sub($min)
    {
        $this->minute -= $min;
        $this->setTime();
        return $this;
    }
    private function setTime()
    {
        while ($this->minute >= 60) {
            $this->minute -= 60;
            $this->hour += 1;
        }
        while ($this->minute < 0) {
            $this->minute += 60;
            $this->hour -= 1;
        }
        while ($this->hour >= 24) {
            $this->hour -= 24;
        }
        while ($this->hour < 0) {
            $this->hour += 24;
        }
    }
}
?>

// 1st Test
$clock = new Clock(3, -20);
// $clock = $clock->sub(60);
echo '
<pre>';
echo $clock->__toString();
echo '</pre>';