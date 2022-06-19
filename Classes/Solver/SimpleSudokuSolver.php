<?php

declare(strict_types=1);

/*
 * This file is part of the package stefanfroemken/sudoku-solver.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace StefanFroemken\SudokuSolver\Solver;

use StefanFroemken\SudokuSolver\Domain\Model\Cell;
use StefanFroemken\SudokuSolver\Domain\Model\Sudoku;

class SimpleSudokuSolver implements SolverInterface
{
    private Sudoku $sudoku;

    public function nextSolution(Sudoku $sudoku): ?Cell
    {
        $this->sudoku = $sudoku;

        for ($x = 0; $x < 9; $x++) {
            for ($y = 0; $y < 9; $y++) {
                $cell = $this->sudoku->getCell($x, $y);
                if ($cell->hasValue()) {
                    continue;
                }

                $possibleValues = $this->getPossibleValuesForPosition($x, $y);
                if (count($possibleValues) === 1) {
                    return new Cell(
                        current($possibleValues),
                        $x,
                        $y,
                        $this->sudoku->getGridPosition($x, $y)
                    );
                }
            }
        }

        return null;
    }

    private function getPossibleValuesForPosition(int $posHorizontal, int $posVertical): array
    {
        $allNumbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        return array_diff($allNumbers, $this->getExcludedValuesForPosition($posHorizontal, $posVertical));
    }

    private function getExcludedValuesForPosition(int $posHorizontal, int $posVertical): array
    {
        $excludedValues = $this->sudoku->getRow($posHorizontal)->getFilledValues();

        $excludedValues = array_merge(
            $excludedValues,
            $this->sudoku->getColumn($posVertical)->getFilledValues()
        );

        $excludedValues = array_merge(
            $excludedValues,
            $this->sudoku->getGrid($this->sudoku->getGridPosition($posHorizontal, $posVertical))->getFilledValues());

        sort($excludedValues);

        return array_values(array_unique($excludedValues));
    }
}
