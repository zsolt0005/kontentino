<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\ErrorData;
use App\Data\LogbookData;
use Illuminate\Http\JsonResponse;
use TypeError;

/**
 * Logbook controller.
 *
 * @package App\Http\Controllers
 * @author  Zsolt Döme
 * @since   2023
 */
final class LogbookController extends Controller
{
    /**
     * Create log book endpoint.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        return response()->json(['OK' => 200]);
    }
}
