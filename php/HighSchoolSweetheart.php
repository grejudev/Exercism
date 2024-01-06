<?php

class HighSchoolSweetheart
{
    public function firstLetter(string $name): string
    {
        $name = ltrim($name);
        return $name[0];
    }

    public function initial(string $name): string
    {
        $name = strtoupper($name);
        return $this->firstLetter($name) . ".";
    }

    public function initials(string $name): string
    {
        $nameParts = explode(" ", $name);
        foreach ($nameParts as &$part) {
            $part = $this->initial($part);
        }
        return implode(" ", $nameParts);
    }

    public function pair(string $sweetheart_a, string $sweetheart_b): string
    {
        $a = $this->initials($sweetheart_a);
        $b = $this->initials($sweetheart_b);

        // Crear el diseño del corazón con las iniciales dentro
        $heart = <<<END
     ******       ******
   **      **   **      **
 **         ** **         **
**            *            **
**                         **
**     $a  +  $b     **
 **                       **
   **                   **
     **               **
       **           **
         **       **
           **   **
             ***
              *
END;

        return $heart;
    }
}
