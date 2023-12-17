<?php declare(strict_types=1);

namespace App\View\Components;

use App\View\Components\Data\SelectFilterData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Select component.
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class SelectFilterComponent extends Component
{
    /**
     * Constructor.
     *
     * @param SelectFilterData $filterData
     */
    public function __construct(private readonly SelectFilterData $filterData)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-filter-component')->with('data', $this->filterData);
    }
}
