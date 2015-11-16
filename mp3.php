<?php
require './vendor/autoload.php';

set_time_limit(0);

while ($word = trim(read_and_delete_first_line(__DIR__.'/vocabulary.txt'))) {
    $content = file_get_contents("https://ssl.gstatic.com/dictionary/static/sounds/de/0/{$word}.mp3");
    file_put_contents(__DIR__."/mp3/{$word}.mp3", $content);
}

echo 'xong';

function read_and_delete_first_line($filename) {
    $file = file($filename);
    $output = isset($file[0]) ? $file[0] : NULL;
    unset($file[0]);
    file_put_contents($filename, $file);
    return $output;
}