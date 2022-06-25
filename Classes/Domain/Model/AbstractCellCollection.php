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
 * Can be a row, a column or a 3x3 grid
 */
abstract class AbstractCellCollection
{
    /**
     * @var Cell[]
     */
    private array $cells;

    private int $position;

    public function __construct(array $cells, int $position)
    {
        $this->cells = $cells;
        $this->position = $position;
    }

    /**
     * @return Cell[]
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    public function getCellWithValue(int $value): ?Cell
    {
        foreach ($this->cells as $cell) {
            if ($cell->getValue() === $value) {
                return $cell;
            }
        }

        return null;
    }

    public function setCell(int $position, Cell $cell): void
    {
        $this->cells[$position] = $cell;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function updateCell(int $position, int $value): void
    {
        $this->cells[$position]->setValue($value);
    }

    public function hasValue(int $value): bool
    {
        foreach ($this->cells as $cell) {
            if ($cell->getValue() === $value) {
                return true;
            }
        }

        return false;
    }

    public function getPossibleValues(): array
    {
        $possibleValues = [];
        for ($i = 1; $i <= 9; $i++) {
            if (!$this->hasValue($i)) {
                $possibleValues[] = $i;
            }
        }

        return $possibleValues;
    }

    public function getFilledValues(): array
    {
        $filledValues = [];
        for ($i = 1; $i <= 9; $i++) {
            if ($this->hasValue($i)) {
                $filledValues[] = $i;
            }
        }

        return $filledValues;
    }
}
