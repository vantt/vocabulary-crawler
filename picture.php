<?php
require './vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;

set_time_limit(0);

// save first picture from ping search

while ($word = trim(read_and_delete_first_line(__DIR__ . '/vocabulary.txt'))) {
    $html    = file_get_contents("https://www.bing.com/images/async?q={$word}");
    $crawler = new Crawler($html);
    for ($i=0; $i<=5; $i++) {
        $json    = $crawler->filter('.imgres .dg_u a')->eq($i)->attr('m');
        $matches = NULL;

        if (preg_match("/imgurl:\"([^\\\"]+)\"/", $json, $matches)) {
            file_put_contents(__DIR__ . "/pictures/{$word}_{$i}.jpg", file_get_contents($matches[1]));
        }
    }



}

echo 'xong';

function read_and_delete_first_line($filename) {
    $file = file($filename);

    if (!empty($file[0])) {
        $output = $file[0];
        unset($file[0]);
        file_put_contents($filename, $file);
        return $output;
    }
}