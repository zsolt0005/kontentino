<?php declare(strict_types=1);

namespace App\View\Components;

use App\View\Components\Data\TwoCellNumberFilterData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Two cell text component.
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class TwoCellNumberFilterComponent extends Component
{
    /**
     * Constructor.
     *
     * @param TwoCellNumberFilterData $filterData
     */
    public function __construct(private readonly TwoCellNumberFilterData $filterData)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.two-cell-number-filter-component')->with('data', $this->filterData);
    }
}
