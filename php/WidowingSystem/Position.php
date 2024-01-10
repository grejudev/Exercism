<?php
include("class.Size.php");

class Position
{

    public $x;
    public $y;

    public function __construct($y, $x)
    {
        $this->x = $x;
        $this->y = $y;
    }
}
