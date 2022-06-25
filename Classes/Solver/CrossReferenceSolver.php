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

class CrossReferenceSolver implements SolverInterface
{
    private Sudoku $sudoku;

    public function nextSolution(Sudoku $sudoku): ?Cell
    {
        $this->sudoku = $sudoku;

        $grids = $this->sudoku->getGrids('top');

        for ($value = 1; $value <= 9; $value++) {
            foreach ($grids as $grid) {
                if (!$grid->hasValue($value)) {
                    continue;
                }
            }
            $gridSiblings = $this->getGridSiblings($grids, $grid->getPosition());
            $posHorizontal = $grid->getCellWithValue($value)->getPosHorizontal();
            foreach ($gridSiblings as $gridSibling) {
                $gridSibling->getGridRow();
            }
        }

        return null;
    }

    /**
     * @return Grid[]
     */
    private function getGridSiblings(array $grids, int $gridPosition): array
    {
        unset($grids[$gridPosition]);

        return $grids;
    }
}
