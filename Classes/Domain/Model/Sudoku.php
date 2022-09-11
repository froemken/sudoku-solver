<?php

declare(strict_types=1);

/*
 * This file is part of the package stefanfroemken/sudoku-solver.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace StefanFroemken\SudokuSolver\Domain\Model;

use StefanFroemken\SudokuSolver\Domain\Exception\AlreadySolvedException;
use StefanFroemken\SudokuSolver\Solver\CrossReferenceSolver;
use StefanFroemken\SudokuSolver\Solver\SimpleSudokuSolver;
use StefanFroemken\SudokuSolver\Solver\SolverInterface;

class Sudoku
{
    /**
     * @var Cell[]
     */
    private array $cells = [];

    /**
     * @var array
     */
    private array $positions = [
        'top' => [0, 1, 2],
        'middle' => [3, 4, 5],
        'bottom' => [6, 7, 8],
        'left' => [0, 3, 6],
        'center' => [1, 4, 7],
        'right' => [2, 5, 8],
    ];

    /**
     * @var SolverInterface[]
     */
    private array $solverClassNames = [
        SimpleSudokuSolver::class,
        CrossReferenceSolver::class
    ];

    public function solve(): array
    {
        // return $this->getPossibleValuesForPosition(0, 0);
    }

    /**
     * @throws AlreadySolvedException
     */
    public function hint(): ?Cell
    {
        if ($this->isSolved()) {
            throw new AlreadySolvedException();
        }

        foreach ($this->solverClassNames as $solverClassName) {
            /** @var SolverInterface $solver */
            $solver = new $solverClassName();
            if ($solution = $solver->nextSolution($this)) {
                return $solution;
            }
        }

        return null;
    }

    public function isSolved(): bool
    {
        $unsolvedCells = array_filter($this->cells, static function (Cell $cell): bool {
            return !$cell->hasValue();
        });

        return $unsolvedCells === [];
    }

    public function addCell(Cell $cell): void
    {
        $this->cells[] = $cell;
    }

    /*
     * Return all cells contained in a row as Row object
     */
    public function getRow(int $position): Row
    {
        return new Row(array_filter($this->cells, static function (Cell $cell) use ($position): bool {
            return $cell->getPosHorizontal() === $position;
        }), $position);
    }

    /*
     * Return all cells contained in a column as Column object
     */
    public function getColumn(int $position): Column
    {
        return new Column(array_filter($this->cells, static function (Cell $cell) use ($position): bool {
            return $cell->getPosVertical() === $position;
        }), $position);
    }

    /*
     * Return all cells contained in a grid (3x3) as Grid object
     */
    public function getGrid(int $gridPosition): Grid
    {
        return new Grid(array_filter($this->cells, static function (Cell $cell) use ($gridPosition): bool {
            return $cell->getGridPosition() === $gridPosition;
        }), $gridPosition);
    }

    /*
     * Return the grid position. 0 = first grid, 8 = last grid
     */
    public function getGridPosition(int $posHorizontal, int $posVertical): int{
        return $this->getCell($posHorizontal, $posVertical)->getGridPosition();
    }

    /*
     * Return a specific cell by exact position
     */
    public function getCell(int $posHorizontal, int $posVertical): Cell
    {
        $cells = array_filter($this->cells, static function (Cell $cell) use ($posHorizontal, $posVertical): bool {
            return $cell->getPosHorizontal() === $posHorizontal && $cell->getPosVertical() === $posVertical;
        });

        return current($cells);
    }

    /**
     * Returns 3 grids in a row or column.
     * Use "top", "middle", "bottom", "left", "center", "right" as keyword
     */
    public function getGrids(string $position): GridCollection
    {
        $gridCollection = new GridCollection();
        foreach ($this->positions[$position] as $gridPosition) {
            $gridCollection->addGrid($this->getGrid($gridPosition));
        }

        return $gridCollection;
    }
}
