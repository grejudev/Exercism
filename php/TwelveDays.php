<?php


declare(strict_types=1);

class TwelveDays
{
    public function recite(int $start, int $end): string
    {
        $output = "";

        $sentence = ["first", "second", "third", "fourth", "fifth", "sixth", "seventh", "eighth", "ninth", "tenth", "eleventh", "twelfth"];
        $presents = [
            "a Partridge in a Pear Tree.",
            "two Turtle Doves, and ",
            "three French Hens, ",
            "four Calling Birds, ",
            "five Gold Rings, ",
            "six Geese-a-Laying, ",
            "seven Swans-a-Swimming, ",
            "eight Maids-a-Milking, ",
            "nine Ladies Dancing, ",
            "ten Lords-a-Leaping, ",
            "eleven Pipers Piping, ",
            "twelve Drummers Drumming, "
        ];


        for ($i = $start - 1; $i < $end; $i++) {
            $output .= "On the " . $sentence[$i] . " day of Christmas my true love gave to me: ";
            $last_part = "";
            for ($j = $i; $j >= 0; $j--) {
                $last_part .= $presents[$j];
            }

            if ($i + 1 == $end) {
                $output .= $last_part;
            } else {
                $output .= $last_part . "\n";
            }
        }

        return $output;
    }
}


$instance = new TwelveDays();
$result = $instance->recite(1, 3);
echo $result;
