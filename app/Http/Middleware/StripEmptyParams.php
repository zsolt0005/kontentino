<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Clears url params that are empty.
 *
 * @package App\Http\Middleware
 * @author  Zsolt Döme
 * @since   2023
 */
final class StripEmptyParams
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return RedirectResponse|Response
     */
    public function handle(Request $request, Closure $next): RedirectResponse|Response
    {
        /** @var scalar[] $query */
        $query = $request->query() ?: [];

        $originalQueryCount = count($query);
        foreach ($query as $key => $value)
        {
            if ($value == '') {
                unset($query[$key]);
            }
        }

        if ($originalQueryCount > count($query))
        {
            $path = url()->current() . (!empty($query) ? '/?' . http_build_query($query) : '');
            return redirect()->to($path);
        }
        return $next($request);
    }
}
