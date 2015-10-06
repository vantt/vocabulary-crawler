#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Vantt\Memrise\Command\UploadFiles;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new UploadFiles());
$application->run();