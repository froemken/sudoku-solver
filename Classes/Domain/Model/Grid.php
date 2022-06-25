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
    public function getGridRow(int $position): GridRow
    {
        return new GridRow(array_filter($this->getCells(), static function (Cell $cell) use ($position): bool {
            return $cell->getPosHorizontal() === $position;
        }), $position);
    }

    public function getGridColumn(int $position): GridRow
    {
        return new GridRow(array_filter($this->getCells(), static function (Cell $cell) use ($position): bool {
            return $cell->getPosVertical() === $position;
        }), $position);
    }
}
