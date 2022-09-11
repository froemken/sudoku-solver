<?php

declare(strict_types=1);

/*
 * This file is part of the package stefanfroemken/sudoku-solver.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace StefanFroemken\SudokuSolver\Domain\Model;

/*
 * This class contains the cells of a GridRow or GridColumn
 */
class Section extends AbstractCellCollection
{
    /**
     * @var int
     */
    protected $gridPosition = 0;

    public function __construct(array $cells, int $gridPosition, int $sectionPosition)
    {
        parent::__construct($cells, $sectionPosition);

        $this->gridPosition = $gridPosition;
    }

    public function isEmpty(): bool
    {
        return $this->getCells() === [];
    }

    public function isFull(): bool
    {
        return !$this->hasEmptyCells();
    }

    public function hasEmptyCells(): bool
    {
        foreach ($this->getCells() as $cell) {
            if (!$cell->hasValue()) {
                return true;
            }
        }

        return false;
    }

    public function getEmptyCells(): array
    {
        $emptyCells = [];
        foreach ($this->getCells() as $cell) {
            if (!$cell->hasValue()) {
                $emptyCells[] = $cell;
            }
        }

        return $emptyCells;
    }

    public function getEmptyCell(): ?Cell
    {
        if ($this->hasEmptyCells()) {
            if ($this->getAmountOfEmptyCells() === 1) {
                $emptyCells = $this->getEmptyCells();

                return current($emptyCells);
            }
        }

        return null;
    }

    public function getAmountOfEmptyCells(): int
    {
        return count($this->getEmptyCells());
    }

    public function getGridPosition(): int
    {
        return $this->gridPosition;
    }
}
