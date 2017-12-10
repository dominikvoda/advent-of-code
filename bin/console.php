<?php

use AOC2017\ResolveCommand;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$app->add(new ResolveCommand());
$app->run();
