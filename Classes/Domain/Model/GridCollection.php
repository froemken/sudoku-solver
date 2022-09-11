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
 * This grid represents 3 small 3x3 grids in a row or column. Not the full Sudoku
 */
class GridCollection
{
    /**
     * @var Grid[]
     */
    protected $grids = [];

    public function addGrid(Grid $grid)
    {
        $this->grids[] = $grid;
    }

    /**
     * @param int $value
     * @param string $direction
     * @return Section[]
     */
    public function getPossibleSections(int $value, string $direction): array
    {
        $possibleSections = $this->getSections($direction);

        foreach ($this->getSectionsWithValue($possibleSections, $value) as $sectionWithValue) {
            $this->removeSectionsByGridPosition($possibleSections, $sectionWithValue->getGridPosition());
            $this->removeSectionsBySectionPosition($possibleSections, $sectionWithValue->getPosition());
        }
        $this->removeFilledSections($possibleSections);

        // Return re-indexed array
        return array_values($possibleSections);
    }

    /**
     * @param string $direction
     * @return Section[]
     */
    protected function getSections(string $direction): array
    {
        $sections = [];
        foreach ($this->grids as $grid) {
            if ($direction === 'horizontal') {
                foreach ($grid->getGridRows() as $rowPos => $gridRow) {
                    $sections[] = new Section($gridRow->getCells(), $gridRow->getGridPosition(), $rowPos);
                }
            } elseif ($direction === 'vertical') {
                foreach ($grid->getGridColumns() as $colPos => $gridColumn) {
                    $sections[] = new Section($gridColumn->getCells(), $gridColumn->getGridPosition(), $colPos);
                }
            }
        }

        return $sections;
    }

    /**
     * @param Section[] $sections
     * @param int $value
     * @return Section[]
     */
    protected function getSectionsWithValue(array $sections, int $value): array
    {
        $sectionsWithValue = [];
        foreach ($sections as $section) {
            if ($section->hasValue($value)) {
                $sectionsWithValue[] = $section;
            }
        }

        return $sectionsWithValue;
    }

    /**
     * If a section has no further place for values, the section is full and can therefor be removed.
     *
     * @param Section[] $sections
     */
    protected function removeFilledSections(array &$sections): void
    {
        foreach ($sections as $key => $section) {
            if ($section->isFull()) {
                unset($sections[$key]);
            }
        }
    }

    /**
     * If value was found in grid 2, then
     * all further sections in same grid can be removed.
     *
     * @param Section[] $sections
     * @param int $gridPosition
     */
    protected function removeSectionsByGridPosition(array &$sections, int $gridPosition): void
    {
        foreach ($sections as $key => $section) {
            if ($section->getGridPosition() === $gridPosition) {
                unset($sections[$key]);
            }
        }
    }

    /**
     * If value was found in a section of first column, then
     * all further sections in first column of the other grids can be removed.
     *
     * @param Section[] $sections
     * @param int $sectionPosition
     */
    protected function removeSectionsBySectionPosition(array &$sections, int $sectionPosition): void
    {
        foreach ($sections as $key => $section) {
            if ($section->getPosition() === $sectionPosition) {
                unset($sections[$key]);
            }
        }
    }
}
