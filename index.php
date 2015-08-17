<?php
require './vendor/autoload.php';

use Vantt\Dictionary;
use Vantt\Google;
use Vantt\TheFreeDictionary;
use Vantt\Webster;

$parsers = [new Google(), new Webster(), new Dictionary(), new TheFreeDictionary()];

set_time_limit(0);

while ($word = trim(read_and_delete_first_line(__DIR__.'/vocabulary.txt'))) {
    $row = array();
    $row[] = $word;

    foreach ($parsers as $parser) {
        $row[] = $parser->getDefinition($word);
    }

    if (!empty($row)) {
        save_csv(__DIR__.'/definition.csv', $row);
    }
}


function read_and_delete_first_line($filename) {
    $file = file($filename);
    $output = $file[0];
    unset($file[0]);
    file_put_contents($filename, $file);
    return $output;
}

function save_csv($filename, $row) {
    $fp = fopen($filename, 'a+');
    fputcsv($fp, $row);
    fclose($fp);
}