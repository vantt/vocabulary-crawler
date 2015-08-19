<?php
require './vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;

set_time_limit(0);

// save first picture from ping search

while ($word = trim(read_and_delete_first_line(__DIR__ . '/vocabulary.txt'))) {
    $html    = file_get_contents("https://www.bing.com/images/async?q=define+{$word}");
    $crawler = new Crawler($html);
    $json    = $crawler->filter('.imgres .dg_u a')->first()->attr('m');

    $matches = NULL;

    if (preg_match("/imgurl:\"([^\\\"]+)\"/", $json, $matches)) {
        file_put_contents(__DIR__ . "/pictures/{$word}.jpg", file_get_contents($matches[1]));
    }
}

echo 'xong';

function read_and_delete_first_line($filename)
{
    $file = file($filename);
    $output = $file[0];
    unset($file[0]);
    file_put_contents($filename, $file);
    return $output;
}