<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\LogbookData;
use App\Models\Logbook;
use App\Services\LogbookService;
use App\Services\PersonService;
use App\Services\PlanetService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @throws HttpException
     */
    public function create(): JsonResponse
    {
        /** @var InputBag $jsonRequest */
        $jsonRequest = request()->json();

        $logBook = LogbookData::from($jsonRequest->all());

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
     * @throws HttpException
     */
    private function createEntry(LogbookData $logbookData): int
    {
        /** @var int $personId */
        $personId = $logbookData->personId;

        /** @var int $planetId */
        $planetId = $logbookData->planetId;

        if($this->personService->fetchById($personId) === null)
        {
            abort(400, 'Person with id ' . $personId . ' does not exists');
        }

        if($this->planetService->fetchById($planetId) === null)
        {
            abort(400, 'Planet with id ' . $planetId . ' does not exists');
        }

        $logbook = Logbook::create([
            Logbook::PERSON_ID => $personId,
            Logbook::PLANET_ID => $planetId,
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
     * @throws HttpException
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
