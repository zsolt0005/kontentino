<?php declare(strict_types=1);

namespace App\Data\Components;

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

    /** @var array<array<mixed>>  */
    public array $rows = [];
}
