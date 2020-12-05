<?php declare(strict_types = 1);

use AdventOfCode\Generator\GenerateSolutionClassesCommand;
use AdventOfCode\ResolveCommand;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app->add(new ResolveCommand());
$app->add(new GenerateSolutionClassesCommand());
$app->run();
