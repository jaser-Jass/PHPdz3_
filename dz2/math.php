<?php


//PHP 8 match
function mathOperation2($arg1, $arg2, $operation)
{
    return match ($operation) {
        'sum' => add($arg1, $arg2),
        'sub' => sub($arg1, $arg2),
        'mult' => mult($arg1, $arg2),
        'div' => div($arg1, $arg2),
        default => 'Error',
    };
}


function mathOperation($arg1, $arg2, $operation)
{
    if (function_exists($operation)) {
        return $operation($arg1, $arg2);
    } else {
        return "Нет такой операции.";
    }

}