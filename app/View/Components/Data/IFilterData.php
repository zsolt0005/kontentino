<?php declare(strict_types=1);

namespace App\View\Components\Data;

/**
 * Represents an interface for a filter data structure.
 *
 * @package App\Data\Components
 * @author  Zsolt Döme
 * @since   2023
 */
interface IFilterData
{
    /**
     * The components name.
     *
     * @return string
     */
    public function getComponentName(): string;

    /**
     * Returns the active state.
     *
     * @return bool
     */
    public function isActive(): bool;
}
