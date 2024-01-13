<?php

function language_list(...$languages)
{
    // implement the language list function
    return $languages;
}

function add_to_language_list($array_languages, $newLanguage)
{
    array_push($array_languages, $newLanguage);
    return $array_languages;
}

function prune_language_list($array_languages)
{
    array_shift($array_languages);
    return $array_languages;
}

function current_language($array_languages)
{
    return $array_languages[0];
}

function language_list_length($array_languages)
{
    return count($array_languages);
}
