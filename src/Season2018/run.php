<?php declare(strict_types = 1);

use AdventOfCode\Season2018\Solutions\ResolveCommand;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../../vendor/autoload.php';

$console = new Application();
$console->add(new ResolveCommand());

$console->run();
