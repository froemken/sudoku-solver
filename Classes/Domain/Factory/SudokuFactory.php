<?php

declare(strict_types=1);

/*
 * This file is part of the package stefanfroemken/sudoku-solver.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace StefanFroemken\SudokuSolver\Domain\Factory;

use StefanFroemken\SudokuSolver\Domain\Model\Cell;
use StefanFroemken\SudokuSolver\Domain\Model\Sudoku;
use TYPO3\CMS\Core\Utility\DebugUtility;

class SudokuFactory
{
    /*
     * Maybe there is a possibility to configure your own structure (non 3x3 grids) in future
     */
    private array $gridStructure = [
        [0, 0, 0, 1, 1, 1, 2, 2, 2],
        [0, 0, 0, 1, 1, 1, 2, 2, 2],
        [0, 0, 0, 1, 1, 1, 2, 2, 2],
        [3, 3, 3, 4, 4, 4, 5, 5, 5],
        [3, 3, 3, 4, 4, 4, 5, 5, 5],
        [3, 3, 3, 4, 4, 4, 5, 5, 5],
        [6, 6, 6, 7, 7, 7, 8, 8, 8],
        [6, 6, 6, 7, 7, 7, 8, 8, 8],
        [6, 6, 6, 7, 7, 7, 8, 8, 8],
    ];

    public function build(array $structure): Sudoku
    {
        $sudoku = new Sudoku();

        foreach ($structure as $posHorizontal => $row) {
            foreach ($row as $posVertical => $value) {
                $sudoku->addCell(
                    new Cell(
                        (int)$value,
                        (int)$posHorizontal,
                        (int)$posVertical,
                        $this->getGridPosition($posHorizontal, $posVertical)
                    )
                );
            }
        }
        DebugUtility::debug($sudoku, 'Sudoku');
        return $sudoku;
    }

    private function getGridPosition(int $posHorizontal, int $posVertical): int
    {
        return $this->gridStructure[$posHorizontal][$posVertical];
    }
}
