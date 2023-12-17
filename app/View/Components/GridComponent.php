<?php declare(strict_types=1);

namespace App\View\Components;

use App\View\Components\Data\GridData;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Grid component.
 *
 * @package App\View\Components
 * @author  Zsolt Döme
 * @since   2023
 */
final class GridComponent extends Component
{
    /**
     * Constructor.
     *
     * @param GridData $gridData
     */
    public function __construct(private readonly GridData $gridData)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.grid-component')->with('data', $this->gridData);
    }
}
