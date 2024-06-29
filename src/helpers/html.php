<?php


/**
 * Its responsible for return select when the options are equals
 *
 * @param mixed $variableValue
 * @param mixed $value
 * @return string
 */
function isSelect(mixed $variableValue, mixed $value): string
{
    return ($variableValue === $value) ? "selected" : '';
}

/**
 * Its responsible for return select when the options are equals
 *
 * @param array<int, mixed> $array
 * @param mixed $value
 * @return string
 */
function isSelectArray($array, $value): string
{
    return in_array($value, $array) ? "selected" : '';
}
