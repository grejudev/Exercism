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

class SimpleCipher
{
    private const ASCII_LOWER_CASE_BOUNDARIES = [97, 123];
    public $numberKey = "";
    public $key = "";

    public function __construct(string $key = null)
    {
        $numberKey = [];
        if ($key !== null && $key !== '') {
            $letters = str_split($key);
            foreach ($letters as $letter) {
                $letterAscii = ord($letter);
                if ($letterAscii < self::ASCII_LOWER_CASE_BOUNDARIES[0] || $letterAscii >= self::ASCII_LOWER_CASE_BOUNDARIES[1]) {
                    throw new \InvalidArgumentException('Text is not valid to encode');
                }
                array_push($numberKey, $letterAscii - self::ASCII_LOWER_CASE_BOUNDARIES[0]);
            }
        } elseif ($key === '') {
            throw new \InvalidArgumentException('Key cannot be empty');
        } else {
            $key = substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 100)), 0, 100);
            $letters = str_split($key);
            foreach ($letters as $letter) {
                $letterAscii = ord($letter);
                array_push($numberKey, $letterAscii - self::ASCII_LOWER_CASE_BOUNDARIES[0]);
            }
        }
        print_r($numberKey);
        echo "<br>";
        $this->numberKey = $numberKey;
        $this->key = $key;
    }

    public function encode(string $plainText): string
    {

        if ($plainText == null) {
            throw new \InvalidArgumentException('Encode Arguments are not valid');
        }

        $letters = str_split($plainText);
        $lettersLength = strlen($plainText); // Obtener la longitud de la clave

        $output = '';
        $i = 0; // Inicializar el contador

        $numberKey = $this->numberKey;

        foreach ($letters as $letter) {
            $letterAscii = ord($letter);
            if ($letterAscii >= self::ASCII_LOWER_CASE_BOUNDARIES[1] && $letterAscii < self::ASCII_LOWER_CASE_BOUNDARIES[0]) {
                throw new \InvalidArgumentException('Text is not valid to encode');
            }

            $letterAscii += intval($numberKey[$i]);
            // $letterAscii += 3;

            // Out of up boundary
            if ($letterAscii >= self::ASCII_LOWER_CASE_BOUNDARIES[1]) {
                $letterAscii -= self::ASCII_LOWER_CASE_BOUNDARIES[1] - self::ASCII_LOWER_CASE_BOUNDARIES[0];
            }
            $letter = chr($letterAscii);
            $output .= $letter;

            $i++; // Incrementar el contador
            if ($i >= $lettersLength) {
                $i = 0; // Reiniciar el contador si alcanza el final de la clave
            }
        }


        return $output;
    }

    public function decode(string $cipherText): string
    {
        if ($cipherText == null) {
            throw new \InvalidArgumentException('Decode Arguments are not valid');
        }

        $letters = str_split($cipherText);
        $lettersLength = strlen($cipherText); // Obtener la longitud de la clave

        $output = '';

        $i = 0; // Inicializar el contador
        $numberKey = $this->numberKey;

        foreach ($letters as $letter) {
            $letterAscii = ord($letter);
            if ($letterAscii >= self::ASCII_LOWER_CASE_BOUNDARIES[1] && $letterAscii < self::ASCII_LOWER_CASE_BOUNDARIES[0]) {
                throw new \InvalidArgumentException('Text is not valid to decode');
            }

            $letterAscii -= intval($numberKey[$i]);
            // $letterAscii -= 3;

            // Out of down boundary
            if ($letterAscii < self::ASCII_LOWER_CASE_BOUNDARIES[0]) {
                $letterAscii += self::ASCII_LOWER_CASE_BOUNDARIES[1] - self::ASCII_LOWER_CASE_BOUNDARIES[0];
            }
            $letter = chr($letterAscii);
            $output .= $letter;

            $i++; // Incrementar el contador
            if ($i >= $lettersLength) {
                $i = 0; // Reiniciar el contador si alcanza el final de la clave
            }
        }

        return $output;
    }
}
