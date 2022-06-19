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
use StefanFroemken\SudokuSolver\Solver\SimpleSudokuSolver;
use StefanFroemken\SudokuSolver\Solver\SolverInterface;

class Sudoku
{
    /**
     * @var Cell[]
     */
    private array $cells = [];

    /**
     * @var SolverInterface[]
     */
    private array $solverClassNames = [
        SimpleSudokuSolver::class
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
     * Return all cells contained in a row
     */
    public function getRow(int $position): Row
    {
        return new Row(array_filter($this->cells, static function (Cell $cell) use ($position): bool {
            return $cell->getPosHorizontal() === $position;
        }));
    }

    /*
     * Return all cells contained in a column
     */
    public function getColumn(int $position): Column
    {
        return new Column(array_filter($this->cells, static function (Cell $cell) use ($position): bool {
            return $cell->getPosVertical() === $position;
        }));
    }

    /*
     * Return all cells contained in a grid (3x3)
     */
    public function getGrid(int $position): Grid
    {
        return new Grid(array_filter($this->cells, static function (Cell $cell) use ($position): bool {
            return $cell->getGridPosition() === $position;
        }));
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
}
