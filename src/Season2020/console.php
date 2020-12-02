<?php declare(strict_types = 1);

use AdventOfCode\Season2020\ResolveCommand;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Application();
$app->add(new ResolveCommand());
$app->run();
