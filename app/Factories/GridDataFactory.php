<?php declare(strict_types=1);

namespace App\Factories;

use App\View\Components\Data\GridData;
use App\View\Components\Data\IFilterData;
use Illuminate\Contracts\Support\Htmlable;

/**
 * Factory for {@see GridData}.
 *
 * @package App\Factories
 * @author  Zsolt Döme
 * @since   2023
 */
final class GridDataFactory
{
    /** @var GridData Internal data structure */
    private GridData $gridData;

    /** Constructor. */
    private function __construct()
    {
        $this->gridData = new GridData();
    }

    /**
     * Factory method.
     *
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * Adds a column title to the header.
     *
     * @param string $columnTitle The title of the column to be added.
     *
     * @return self
     */
    public function addHeader(string $columnTitle): self
    {
        $this->gridData->headerColumns[] = $columnTitle;
        return $this;
    }

    /**
     * Adds a new row to the grid.
     *
     * @return self
     */
    public function addRow(): self
    {
        $this->gridData->rows[] = [];

        return $this;
    }

    /**
     * Adds a cell value to the last row in the grid.
     *
     * @param scalar $value The value of the cell to be added.
     *
     * @return self
     */
    public function addCell(mixed $value): self
    {
        $lastRowIndex = array_key_last($this->gridData->rows);
        $this->gridData->rows[$lastRowIndex][] = $value;

        return $this;
    }

    public function setLinks(?Htmlable $links): self
    {
        $this->gridData->links = $links;

        return $this;
    }

    /**
     * Adds a new filter to the grid.
     *
     * @param IFilterData $filterData
     *
     * @return self
     */
    public function addFilter(IFilterData $filterData): self
    {
        $this->gridData->filters[] = $filterData;

        return $this;
    }

    /**
     * Returns the built data.
     *
     * @return GridData
     */
    public function build(): GridData
    {
        return $this->gridData;
    }
}
