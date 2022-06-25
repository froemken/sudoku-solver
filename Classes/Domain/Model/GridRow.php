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
 * This class represents a row in a 3x3 grid
 */
class GridRow extends AbstractCellCollection
{
    /*
     * Returns, if all cells in grid row are filled
     */
    public function isFull(): bool
    {
        $this->getPossibleValues() === [];
    }
}
