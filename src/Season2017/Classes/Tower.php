<?php

namespace AdventOfCode\Season2017\Classes;

class Tower
{
    /**
     * @var Program[]
     */
    private $programs;

    public function __construct()
    {
        $this->programs = [];
        $this->root = null;
    }

    /**
     * @param Program $program
     */
    public function registerProgram(Program $program): void
    {
        $this->programs[$program->getName()] = $program;
    }

    /**
     * @return string
     */
    public function getRoot(): string
    {
        $this->buildStructure();

        /** @var Program $program */
        foreach ($this->programs as $program) {
            if (!$program->hasRoot()) {
                return $program->getName();
            }
        }

        return 'not found';
    }

    /**
     * @return int
     */
    public function getInvalidWeight(): int
    {
        $root = $this->findProgram($this->getRoot());

        return Program::getInvalidWeightProgram($root);
    }

    private function buildStructure(): void
    {
        /** @var Program $program */
        foreach ($this->programs as $program) {
            foreach ($program->getChilds() as $child) {
                $children = $this->findProgram($child);
                $children->setRoot($program);
                $program->addRealChildren($children);
            }
        }
    }

    /**
     * @param string $name
     *
     * @return Program
     */
    private function findProgram(string $name): Program
    {
        return $this->programs[$name];
    }
}
