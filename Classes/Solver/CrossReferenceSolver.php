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
use StefanFroemken\SudokuSolver\Domain\Model\Grid;
use StefanFroemken\SudokuSolver\Domain\Model\GridCollection;
use StefanFroemken\SudokuSolver\Domain\Model\Sudoku;

class CrossReferenceSolver implements SolverInterface
{
    private Sudoku $sudoku;

    public function nextSolution(Sudoku $sudoku): ?Cell
    {
        $this->sudoku = $sudoku;
        $cell = null;

        foreach (['top', 'middle', 'bottom'] as $position) {
            $cell = $this->getPossibleCell($this->sudoku->getGrids($position), 'horizontal');
            if ($cell instanceof Cell) {
                break;
            }
        }

        foreach (['left', 'center', 'right'] as $position) {
            $cell = $this->getPossibleCell($this->sudoku->getGrids($position), 'vertical');
            if ($cell instanceof Cell) {
                break;
            }
        }

        return $cell;
    }

    /**
     * @param GridCollection $gridCollection
     * @param string $direction
     * @return Cell|null
     */
    protected function getPossibleCell(GridCollection $gridCollection, string $direction): ?Cell
    {
        for ($value = 1; $value <= 9; $value++) {
            $possibleSections = $gridCollection->getPossibleSections($value, $direction);
            if (count($possibleSections) === 1) {
                $possibleSection = $possibleSections[0];
                $cell = $possibleSection->getEmptyCell();
                if ($cell instanceof Cell) {
                    $cell->setValue($value);

                    return $cell;
                }
            }
        }

        return null;
    }
}
