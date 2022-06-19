<?php

declare(strict_types=1);

/*
 * This file is part of the package stefanfroemken/sudoku-solver.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace StefanFroemken\SudokuSolver\Domain\Model;

class Cell
{
    private int $value;
    private int $posHorizontal;
    private int $posVertical;
    private int $gridPosition;

    public function __construct(int $value, int $posHorizontal, int $posVertical, int $gridPosition)
    {
        $this->value = $value;
        $this->posHorizontal = $posHorizontal;
        $this->posVertical = $posVertical;
        $this->gridPosition = $gridPosition;
    }

    public function hasValue(): bool
    {
        return $this->value !== 0;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getPosHorizontal(): int
    {
        return $this->posHorizontal;
    }

    public function setPosHorizontal(int $posHorizontal): void
    {
        $this->posHorizontal = $posHorizontal;
    }

    public function getPosVertical(): int
    {
        return $this->posVertical;
    }

    public function setPosVertical(int $posVertical): void
    {
        $this->posVertical = $posVertical;
    }

    public function getGridPosition(): int
    {
        return $this->gridPosition;
    }

    public function setGridPosition(int $gridPosition): void
    {
        $this->gridPosition = $gridPosition;
    }
}
