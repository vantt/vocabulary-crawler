<?php
require './vendor/autoload.php';

use Vantt\Dictionary;
use Vantt\Google;
use Vantt\TheFreeDictionary;
use Vantt\Webster;

$webster = new Webster();
$parsers = [new Google(), $webster, new Dictionary(), new TheFreeDictionary()];

echo $webster->getDefinition('box');
exit;

foreach ($parsers as $parser) {
    echo $parser->getDefinition('box'), '<br/><br/>';
}