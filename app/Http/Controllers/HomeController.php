<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\View\View;

/**
 * Home page controller.
 *
 * @package App\Http\Controllers
 * @author  Zsolt Döme
 * @since   2023
 */
final class HomeController extends Controller
{
    /**
     * Constructor.
     *
     * @param HomeService $homeService
     */
    public function __construct(private readonly HomeService $homeService)
    {
    }

    /**
     * Returns the default view.
     *
     * @return View The default view.
     */
    public function default(): View
    {
        $gridData = $this->homeService->prepareGridData();

        return view('home')->with('gridData', $gridData);
    }
}
