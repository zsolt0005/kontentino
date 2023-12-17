<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Clears url params that are empty.
 *
 * @package App\Http\Middleware
 * @author  Zsolt Döme
 * @since   2023
 */
final class StripEmptyParams
{
    public function handle(Request $request, Closure $next)
    {
        $query = $request->query();

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
