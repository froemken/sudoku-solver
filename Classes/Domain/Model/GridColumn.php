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
 * This class represents a column in a 3x3 grid
 */
class GridColumn extends AbstractCellCollection
{
    /**
     * @var int
     */
    protected $gridPosition = 0;

    public function __construct(array $cells, int $gridPosition, int $verticalPosition)
    {
        parent::__construct($cells, $verticalPosition);

        $this->gridPosition = $gridPosition;
    }

    /*
     * Returns, if all cells in grid column are filled
     */
    public function isFull(): bool
    {
        $this->getPossibleValues() === [];
    }

    public function getGridPosition(): int
    {
        return $this->gridPosition;
    }
}
