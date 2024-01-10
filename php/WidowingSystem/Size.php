<?php
include("class.Position.php");

class Size
{

    public $height;
    public $width;

    public function __construct($height, $width)
    {
        $this->height = $height;
        $this->width = $width;
    }
}
