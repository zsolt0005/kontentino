<?php declare(strict_types=1);

namespace App\View\Components;

use App\View\Components\Data\TextFilterData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Text component.
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class TextFilterComponent extends Component
{
    /**
     * Constructor.
     *
     * @param TextFilterData $filterData
     */
    public function __construct(private readonly TextFilterData $filterData)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.text-filter-component')->with('data', $this->filterData);
    }
}
