<?php

declare(strict_types=1);

class Bob
{
    public function respondTo($input)
    {
        // Remove leading and trailing whitespace
        $input = trim($input);

        // Check if the input is empty or contains only whitespace
        if (empty($input)) {
            return "Fine. Be that way!";
        }

        // Check if the input is in all uppercase (yelling)
        if (preg_match('/[A-Z]/', $input) && $input === strtoupper($input)) {
            // Check if the input is a question
            if (substr($input, -1) === '?') {
                return "Calm down, I know what I'm doing!";
            } else {
                return "Whoa, chill out!";
            }
        }

        // Check if the input ends with a question mark (a question)
        if (substr($input, -1) === '?') {
            return "Sure.";
        }

        // Default response
        return "Whatever.";
    }
}
