<?php

$fileContents = file_get_contents('./file.txt', 'rb');

echo $fileContents;
// docker run --rm -v ${pwd}/lesson/code/:/cli php:8.2-cli php /cli/read.php