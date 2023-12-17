<?php declare(strict_types=1);

namespace App\View\Components\Data;

use Illuminate\Contracts\Support\Htmlable;

/**
 * Represents a grid data structure with header columns and rows.
 *
 * @package App\Data\Components
 * @author  Zsolt Döme
 * @since   2023
 */
final class GridData
{
    /** @var array<string> Headers. */
    public array $headerColumns = [];

    /** @var array<array<scalar>> Rows. */
    public array $rows = [];

    /** @var Htmlable|null Links. */
    public ?Htmlable $links = null;

    /** @var array<IFilterData> Filters. */
    public array $filters = [];
}
