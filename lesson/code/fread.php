<?php

$file = fopen('file.txt', 'rb');
$data = fread($file, 120);
fclose($file);
echo $data;