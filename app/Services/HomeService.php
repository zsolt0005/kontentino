<?php declare(strict_types=1);

namespace App\Services;

use App\Data\Components\GridData;
use App\Factories\GridDataFactory;
use App\Models\Planet;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Number;

/**
 * Class HomeService
 *
 * @package App\Services
 * @author  Zsolt Döme
 * @since   2023
 */
final class HomeService
{
    public function __construct(private readonly PlanetService $planetService)
    {
    }

    public function prepareGridData(): GridData
    {
        $planetsPagination = $this->getPlanetsPagination(10);

        $gridData = GridDataFactory::create()
            ->addHeader('#')
            ->addHeader('Name')
            ->addHeader('Diameter')
            ->addHeader('Rotation period')
            ->addHeader('Gravity')
            ->addHeader('Population')
            ->addHeader('Climate')
            ->addHeader('Terrain')
            ->addHeader('Surface water')
            ->addHeader('Orbital period');

        /** @var Planet $planet */
        foreach ($planetsPagination as $planet)
        {
            $rotationPeriod = $planet->getRotationPeriod() !== null ? $planet->getRotationPeriod() . ' days' : '-';
            $orbitalPeriod = $planet->getOrbitalPeriod() !== null ? $planet->getOrbitalPeriod() . ' hours' : '-';
            $diameter = $planet->getDiameter() !== null ? Number::format($planet->getDiameter()) . ' km' : '-';
            $population = $planet->getPopulation() !== null ? Number::format($planet->getPopulation()) : '-';
            $surfaceWater = $planet->getSurfaceWater() !== null ? Number::percentage($planet->getSurfaceWater()) : '-';

            $gridData->addRow()
                ->addCell($planet->getId())
                ->addCell($planet->getName())
                ->addCell($diameter)
                ->addCell($rotationPeriod)
                ->addCell($planet->getGravity() ?: '-')
                ->addCell($population)
                ->addCell($planet->getClimate() ?: '-')
                ->addCell($planet->getTerrain() ?: '-')
                ->addCell($surfaceWater)
                ->addCell($orbitalPeriod);
        }

        return $gridData->build();
    }

    /**
     * Gets the pagination for the planets.
     *
     * @param positive-int $itemsPerPage
     * @return LengthAwarePaginator<Planet>
     */
    private function getPlanetsPagination(int $itemsPerPage): LengthAwarePaginator
    {
        $planetsPagination = $this->planetService->paginate($itemsPerPage);

        if($planetsPagination->currentPage() > $planetsPagination->lastPage())
        {
            return $this->planetService->paginate($itemsPerPage, page: $planetsPagination->lastPage());
        }

        return $planetsPagination;
    }
}
