<?php

declare(strict_types=1);

/*
 * This file is part of the package stefanfroemken/sudoku-solver.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace StefanFroemken\SudokuSolver\UserFunc;

use Psr\Http\Message\ServerRequestInterface;
use StefanFroemken\SudokuSolver\Domain\Exception\AlreadySolvedException;
use StefanFroemken\SudokuSolver\Domain\Factory\SudokuFactory;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class CallSudoku
{
    public ContentObjectRenderer $contentObjectRenderer;

    public SudokuFactory $sudokuFactory;

    public function __construct(SudokuFactory $sudokuFactory)
    {
        $this->sudokuFactory = $sudokuFactory;
    }

    public function solve(string $content, array $parameters, ServerRequestInterface $request)
    {
        $sudoku = $this->sudokuFactory->build([
            [1, 5, 3, 2, 9, 7, 6, 8, 4],
            [7, 2, 6, 4, 8, 5, 3, 1, 9],
            [9, 4, 8, 1, 6, 3, 7, 2, 5],
            [6, 8, 2, 9, 1, 4, 5, 7, 3],
            [3, 7, 4, 6, 5, 2, 8, 9, 1],
            [5, 9, 1, 3, 7, 8, 4, 6, 2],
            [2, 1, 5, 8, 4, 6, 9, 3, 7],
            [4, 6, 9, 7, 3, 1, 2, 5, 8],
            [8, 3, 7, 5, 2, 9, 1, 4, 6],
        ]);

        try {
            $hint = $sudoku->hint();

            DebugUtility::debug(
                sprintf(
                    'Set value %d in row %d and col %d',
                    $hint->getValue(),
                    $hint->getPosHorizontal() + 1,
                    $hint->getPosVertical() + 1
                ),
                'Next Solution'
            );
        } catch (AlreadySolvedException $alreadySolvedException) {
            DebugUtility::debug('Sudoku already solved', 'Error');
        }

        return '<h1>Solve</h1>';
    }
}
