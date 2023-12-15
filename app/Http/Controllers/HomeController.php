<?php declare(strict_types = 1);

namespace App\Http\Controllers;

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
     * Returns the default view.
     *
     * @return View The default view.
     */
    public function default(): View
    {
        return view('welcome');
    }
}
