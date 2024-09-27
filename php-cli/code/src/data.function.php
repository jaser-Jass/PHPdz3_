<?php

function validateDate(string $date): bool {
    $dateBlocks = explode("-", $date);

    // Проверка на правильное количество блоков: должно быть 3 (день, месяц, год)
    if (count($dateBlocks) !== 3) {
        return false;
    }

    // Приводим каждый блок к целым числам
    $day = (int)$dateBlocks[0];
    $month = (int)$dateBlocks[1];
    $year = (int)$dateBlocks[2];

    // Проверка диапазонов
    if ($day < 1 && $day > 31) {
        return false;
    }
    if ($month < 1 && $month > 12) {
        return false;
    }
    if ($year < 1900 && $year > date('Y')) {
        return false;
    }

    // Дополнительная проверка на количество дней в месяце
    if (!checkdate($month, $day, $year)) {
        return false; // Дата не существует
    }

    return true;
}