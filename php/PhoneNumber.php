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

class PhoneNumber
{
    private $stringNumber;

    public function __construct(string $str = null)
    {
        $this->stringNumber = $str;
        $this->validate();
    }

    public function validate(): void
    {
        if (preg_match('/[A-Za-z]/', $this->stringNumber)) {
            throw new InvalidArgumentException('letters not permitted');
        }
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]{2,}/', $this->stringNumber)) {
            throw new InvalidArgumentException("punctuations not permitted", 1);
        }
        if (strlen($this->stringNumber) === 11 && $this->stringNumber[0] !== "1") {
            throw new InvalidArgumentException("11 digits must start with 1");
        }

        // Remove non-numeric characters and country code (1)
        $this->stringNumber = preg_replace('/[^0-9]/', '', $this->stringNumber);
        if (strlen($this->stringNumber) === 11 && $this->stringNumber[0] === "1") {
            $this->stringNumber = substr($this->stringNumber, 1);
        }

        if (preg_match('/[A-Za-z]/', $this->stringNumber)) {
            throw new InvalidArgumentException('letters not permitted');
        }

        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]{2,}/', $this->stringNumber)) {
            throw new InvalidArgumentException("punctuations not permitted", 1);
        }

        if (strlen($this->stringNumber) < 10) {
            throw new InvalidArgumentException("incorrect number of digits", 1);
        } elseif (strlen($this->stringNumber) > 11) {
            throw new InvalidArgumentException("more than 11 digits", 1);
        }

        // Validate area and exchange codes
        $areaCode = substr($this->stringNumber, 0, 3);
        $exchangeCode = substr($this->stringNumber, 3, 3);

        if ($areaCode[0] === '0') {
            throw new InvalidArgumentException("area code cannot start with zero");
        } elseif ($areaCode[0] === '1') {
            throw new InvalidArgumentException("area code cannot start with one");
        }

        if ($exchangeCode[0] === '0') {
            throw new InvalidArgumentException("exchange code cannot start with zero");
        } elseif ($exchangeCode[0] === '1') {
            throw new InvalidArgumentException("exchange code cannot start with one");
        }
    }

    public function number(): string
    {
        return $this->stringNumber;
    }
}
