<?php
require './vendor/autoload.php';

use Vantt\Google;
use Vantt\TheFreeDictionary;
use Vantt\Webster;

$parser = new \Vantt\Dictionary('carpenter');
$a = $parser->getDefinition();
