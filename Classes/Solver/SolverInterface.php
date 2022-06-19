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

interface SolverInterface
{
    public function nextSolution(Sudoku $sudoku): ?Cell;
}
