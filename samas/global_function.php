<?php

/**
 * Recursively checks if a value exists in an array
 * @param  mixed $needle   The searched value
 * @param  array $haystack The array
 * @param  bool  $strict   Check the types
 * @return bool
 */
function in_array_r($needle, $haystack, $strict = false)
{

    foreach ($haystack as $item) {

        if (   ($strict ? $item === $needle : $item == $needle)
            || (is_array($item) && in_array_r($needle, $item, $strict))
        ) {

            return true;

        }

    }

    return false;

}

function model($table_name, $allow_reflection = true)
{

}