<?php
function sum($a, $b)
{
    return $a + $b;
}

function sub($a, $b)
{
    return $a - $b;
}

function mult($a, $b)
{
    return $a * $b;
}

function div($a, $b)
{
    return ($b != 0) ? $a / $b : "Деление на 0";
}

echo "результат 2 / 0 = " . div(2, 0) . PHP_EOL;

function mathOperation($arg1, $arg2, $operation)
{

    switch ($operation) {
        case '+':
            $res = sum($arg1, $arg2);
            break;
        case '-':
            $res = sub($arg1, $arg2);
            break;
        case '*':
            $res = mult($arg1, $arg2);
            break;
        case '/':
            $res = div($arg1, $arg2);
            break;
        default:
            $res = "Не верная операция.";
    }

    return $res;
}

echo "результат 2 + 3 = " . mathOperation(2, 3, '+') . PHP_EOL;

function mathOperation2($arg1, $arg2, $operation)
{
    return match ($operation) {
        'add' => sum($arg1, $arg2),
        'sub' => sub($arg1, $arg2),
        'mult' => mult($arg1, $arg2),
        '/' => div($arg1, $arg2),
        default => "Не верная операция.",
    };
}


echo "результат 2 * 2 = " . mathOperation2(2, 2, 'mult') . PHP_EOL;

function power($val, $pow)
{
    if ($pow === 0) return 1;
    elseif ($pow < 0) {
        if ($val === 0) return "Ошибка";
        return 1 / ($val * power($val, -$pow - 1));
    }
    return $val * power($val, $pow - 1);

}

echo "результат 2 ^ -1 = " . power(2, -1) . PHP_EOL;

//Простой вариант
function power2($val, $pow)
{
    if ($pow == 0) return 1;
    return $val * power($val, $pow - 1);
}

echo "результат 2 ^ 3 = " . power2(2, 3) . PHP_EOL;