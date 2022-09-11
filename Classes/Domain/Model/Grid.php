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
 * This grid represents the small 3x3 grids. Not the full Sudoku
 */
class Grid extends AbstractCellCollection
{
    /**
     * @return GridRow[]
     */
    public function getGridRows(): array
    {
        $gridRows = [];
        foreach ($this->getHorizontalPositions() as $horizontalPosition) {
            $gridRows[] = $this->getGridRow($horizontalPosition);
        }

        return $gridRows;
    }

    /**
     * @return GridColumn[]
     */
    public function getGridColumns(): array
    {
        $gridColumns = [];
        foreach ($this->getVerticalPositions() as $verticalPosition) {
            $gridColumns[] = $this->getGridColumn($verticalPosition);
        }

        return $gridColumns;
    }

    public function getGridRow(int $horizontalPosition): ?GridRow
    {
        $cells = array_filter($this->getCells(), static function (Cell $cell) use ($horizontalPosition): bool {
            return $cell->getPosHorizontal() === $horizontalPosition;
        });

        if ($cells !== []) {
            return new GridRow($cells, $this->getGridPosition(), $horizontalPosition);
        }

        return null;
    }

    public function getGridColumn(int $verticalPosition): ?GridColumn
    {
        $cells = array_filter($this->getCells(), static function (Cell $cell) use ($verticalPosition): bool {
            return $cell->getPosVertical() === $verticalPosition;
        });

        if ($cells !== []) {
            return new GridColumn($cells, $this->getGridPosition(), $verticalPosition);
        }

        return null;
    }

    public function getGridPosition(): int
    {
        return $this->getPosition();
    }

    protected function getVerticalPositions(): array
    {
        $verticalPositions = [];
        foreach ($this->getCells() as $cell) {
            if (!in_array($cell->getPosVertical(), $verticalPositions, true)) {
                $verticalPositions[] = $cell->getPosVertical();
            }
        }

        return $verticalPositions;
    }

    protected function getHorizontalPositions(): array
    {
        $horizontalPositions = [];
        foreach ($this->getCells() as $cell) {
            if (!in_array($cell->getPosHorizontal(), $horizontalPositions, true)) {
                $horizontalPositions[] = $cell->getPosHorizontal();
            }
        }

        return $horizontalPositions;
    }
}
