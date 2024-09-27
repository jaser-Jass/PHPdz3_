<?php

// function readAllFunction(string $address) : string {
function readAllFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);
        return $contents;
    }
    else {
        return handleError("Файл не существует");
    }
}

// function addFunction(string $address) : string {
function addFunction(array $config) : string {
    $address = $config['storage']['address'];

    $name = readline("Введите имя: ");
    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");

    if (!validateDate($date)) {
        return handleError("Неверный формат даты");

    }
    $data = $name . ", " . $date . "\r\n";

    $fileHandler = fopen($address, 'a');

    if(fwrite($fileHandler, $data)){
        return "Запись $data добавлена в файл $address"; 
    }
    else {
        return handleError("Произошла ошибка записи. Данные не сохранены");
    }

    fclose($fileHandler);
}

// function clearFunction(string $address) : string {
function clearFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "w");
        
        fwrite($file, '');
        
        fclose($file);
        return "Файл очищен";
    }
    else {
        return handleError("Файл не существует");
    }
}

function helpFunction() {
    return handleHelp();
}

function readConfig(string $configAddress): array|false{
    return parse_ini_file($configAddress, true);
}

function readProfilesDirectory(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!is_dir($profilesDirectoryAddress)){
        mkdir($profilesDirectoryAddress);
    }

    $files = scandir($profilesDirectoryAddress);

    $result = "";

    if(count($files) > 2){
        foreach($files as $file){
            if(in_array($file, ['.', '..']))
                continue;
            
            $result .= $file . "\r\n";
        }
    }
    else {
        $result .= "Директория пуста \r\n";
    }

    return $result;
}

function readProfile(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!isset($_SERVER['argv'][2])){
        return handleError("Не указан файл профиля");
    }

    $profileFileName = $profilesDirectoryAddress . $_SERVER['argv'][2] . ".json";

    if(!file_exists($profileFileName)){
        return handleError("Файл $profileFileName не существует");
    }

    $contentJson = file_get_contents($profileFileName);
    $contentArray = json_decode($contentJson, true);

    $info = "Имя: " . $contentArray['name'] . "\r\n";
    $info .= "Фамилия: " . $contentArray['lastname'] . "\r\n";

    return $info;
}

function searchFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (!file_exists($address) && !is_readable($address)) {
        return handleError("Файл не существует или не доступен для чтения");
    }

    $name = readline("Введите имя для поиска: ");
    $file = fopen($address, "r");
    $found = false;
    $result = "";

    while (($line = fgets($file)) !== false) {
        if (strpos($line, $name) !== false) {
            $result .= $line; // Запись найдена
            $found = true;
        }
    }

    fclose($file);

    if ($found) {
        return "Найденные записи:" . "\r\n" . $result;
    } else {
        return "Записи с именем '$name' не найдены.";
    }
}

function findAndDeleteFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (!file_exists($address) && !is_readable($address)) {
        return handleError("Файл не существует или не доступен для чтения");
    }

    $name = readline("Введите имя для удаления: ");
    $file = fopen($address, "r");
    $lines = [];
    $found = false;

    // Читаем все строки файла
    while (($line = fgets($file)) !== false) {
        if (strpos($line, $name) !== false) {
            $found = true; // Запись найдена
            continue; // Пропускаем найденную запись
        }
        // Сохраняем остальные строки
        $lines[] = $line;
    }

    fclose($file);

    // Если запись найдена, обновляем файл
    if ($found) {
        $fileHandler = fopen($address, 'w');
        foreach ($lines as $line) {
            fwrite($fileHandler, $line); // Записываем обратно все, кроме удаленной записи
        }
        fclose($fileHandler);
        return "Запись с именем '$name' удалена.";
    } else {
        return "Записи с именем '$name' не найдены.";
    }
}

function findBirthdayContacts(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");

        $contacts = [];
        $today = date("d-m");

        while (!feof($file)) {
            $line = fgets($file);
            $data = explode(", ", $line);
            if (count($data) == 2) {
                $birthday = substr($data[1], 0, 5);
                if ($birthday == $today) {
                    $contacts[] = $data[0] . " - " . $data[1];
                }
            }
        }

        fclose($file);

        if (count($contacts) > 0) {
            return "Контакты с днем рождения сегодня:\n" . implode("\n", $contacts);
        } else {
            return "Сегодня нет контактов с днем рождения";
        }
    } else {
        return handleError("Файл не существует");
    }
}