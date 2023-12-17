<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\LogbookData;
use App\Models\Logbook;
use App\Services\LogbookService;
use App\Services\PersonService;
use App\Services\PlanetService;
use Illuminate\Http\JsonResponse;

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
     * Constructor.
     *
     * @param PersonService $personService
     * @param PlanetService $planetService
     * @param LogbookService $logbookService
     */
    public function __construct(
        private readonly PersonService $personService,
        private readonly PlanetService $planetService,
        private readonly LogbookService $logbookService
    )
    {
    }

    /**
     * Create log book endpoint.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $logBook = LogbookData::from(request()->json()->all());

        $this->validateNewLogbookData($logBook);
        $createdLogBookId = $this->createEntry($logBook);

        return response()->json(['logBookId' => $createdLogBookId], 201);
    }

    /**
     * Retrieve an existing logbook.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        $logBook = $this->logbookService->fetchById($id);

        if($logBook === null)
        {
            return response()->json(['message' => 'Logbook not found for id: ' . $id], 404);
        }

        return response()->json($logBook);
    }

    /**
     * Creates a new logbook.
     *
     * @param LogbookData $logbookData
     *
     * @return int
     */
    private function createEntry(LogbookData $logbookData): int
    {
        if($this->personService->fetchById($logbookData->personId) === null)
        {
            abort(400, 'Person with id ' . $logbookData->personId . ' does not exists');
        }

        if($this->planetService->fetchById($logbookData->planetId) === null)
        {
            abort(400, 'Planet with id ' . $logbookData->planetId . ' does not exists');
        }

        $logbook = Logbook::create([
            Logbook::PERSON_ID => $logbookData->personId,
            Logbook::PLANET_ID => $logbookData->planetId,
            Logbook::LATITUDE => $logbookData->latitude,
            Logbook::LONGITUDE => $logbookData->longitude,
            Logbook::SEVERITY => $logbookData->severity,
            Logbook::NOTE => $logbookData->note
        ]);

        return $logbook->getId();
    }

    /**
     * Validates data.
     *
     * @param LogbookData $logbookData
     *
     * @return void
     */
    private function validateNewLogbookData(LogbookData $logbookData): void
    {
        if($logbookData->personId === null) abort(400, 'Missing required property personId');
        if($logbookData->planetId === null) abort(400, 'Missing required property planetId');
        if($logbookData->latitude === null) abort(400, 'Missing required property latitude');
        if($logbookData->longitude === null) abort(400, 'Missing required property longitude');
        if($logbookData->severity === null) abort(400, 'Missing required property severity');
        if($logbookData->note === null) abort(400, 'Missing required property note');

        if($logbookData->personId <= 0) abort(400, 'Invalid property value ' . $logbookData->personId . ' for property personId');
        if($logbookData->planetId <= 0) abort(400, 'Invalid property value ' . $logbookData->planetId . ' for property planetId');
    }
}
