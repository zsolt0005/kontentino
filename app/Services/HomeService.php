<?php declare(strict_types=1);

namespace App\Services;

use App\Factories\GridDataFactory;
use App\Models\Planet;
use App\Utils\TypeUtils;
use App\View\Components\Data\GridData;
use App\View\Components\Data\SelectFilterData;
use App\View\Components\Data\SelectFilterValueData;
use App\View\Components\Data\TextFilterData;
use App\View\Components\Data\TwoCellNumberFilterData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;
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
    private const FILTER_NAME = 'filter-name';
    private const FILTER_DIAMETER_LEFT = 'filter-diameter-left';
    private const FILTER_DIAMETER_RIGHT = 'filter-diameter-right';
    private const FILTER_ROTATION_PERIOD_LEFT = 'filter-rotation-period-left';
    private const FILTER_ROTATION_PERIOD_RIGHT = 'filter-rotation-period-right';
    private const FILTER_GRAVITY = 'filter-gravity';

    /**
     * Prepares the grid data.
     *
     * @return GridData
     */
    public function prepareGridData(): GridData
    {
        $queryParams = Request::query();

        $nameFilterValue = $queryParams[self::FILTER_NAME] ?? null;
        $diameterFromFilterValue = TypeUtils::convertToInt($queryParams[self::FILTER_DIAMETER_LEFT] ?? null);
        $diameterToFilterValue =  TypeUtils::convertToInt($queryParams[self::FILTER_DIAMETER_RIGHT] ?? null);
        $rotationPeriodFromFilterValue =  TypeUtils::convertToInt($queryParams[self::FILTER_ROTATION_PERIOD_LEFT] ?? null);
        $rotationPeriodToFilterValue =  TypeUtils::convertToInt($queryParams[self::FILTER_ROTATION_PERIOD_RIGHT] ?? null);
        $gravityFilterValue = $queryParams[self::FILTER_GRAVITY] ?? null;

        $planets = Planet::query();
        if($nameFilterValue !== null) $planets->where(Planet::NAME, 'like', $nameFilterValue . '%');
        if($diameterFromFilterValue !== null) $planets->where(Planet::DIAMETER, '>=', $diameterFromFilterValue);
        if($diameterToFilterValue !== null) $planets->where(Planet::DIAMETER, '<=', $diameterToFilterValue);
        if($rotationPeriodFromFilterValue !== null) $planets->where(Planet::ROTATION_PERIOD, '>=', $rotationPeriodFromFilterValue);
        if($rotationPeriodToFilterValue !== null) $planets->where(Planet::ROTATION_PERIOD, '<=', $rotationPeriodToFilterValue);
        if($gravityFilterValue !== null) $planets->where(Planet::GRAVITY, '=' , $gravityFilterValue);

        $planetsPagination = $this->getPlanetsPagination($planets);

        $gridDataFactory = GridDataFactory::create()
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

            $gridDataFactory->addRow()
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

        $gridDataFactory->setLinks($planetsPagination->appends($queryParams)->onEachSide(1)->links());

        $gridDataFactory->addFilter(TextFilterData::create(self::FILTER_NAME, 'Name', $nameFilterValue));
        $gridDataFactory->addFilter(TwoCellNumberFilterData::create(
            self::FILTER_DIAMETER_LEFT,
            self::FILTER_DIAMETER_RIGHT,
            'Diameter',
            leftCellValue: $diameterFromFilterValue,
            rightCellValue: $diameterToFilterValue
        ));
        $gridDataFactory->addFilter(TwoCellNumberFilterData::create(
            self::FILTER_ROTATION_PERIOD_LEFT,
            self::FILTER_ROTATION_PERIOD_RIGHT,
            'Rotation period',
            leftCellValue: $rotationPeriodFromFilterValue,
            rightCellValue: $rotationPeriodToFilterValue
        ));
        $gridDataFactory->addFilter(SelectFilterData::create(
            self::FILTER_GRAVITY,
            'Gravity',
            $gravityFilterValue,
            [SelectFilterValueData::empty(), SelectFilterValueData::create('hello', 'Hello')]
        ));

        return $gridDataFactory->build();
    }

    /**
     * Gets the pagination for the planets.
     *
     * @param Builder $planetsQueryBuilder
     * @return LengthAwarePaginator<Planet>
     */
    private function getPlanetsPagination(Builder $planetsQueryBuilder): LengthAwarePaginator
    {
        $planetsPagination = $planetsQueryBuilder->paginate(10);

        if($planetsPagination->currentPage() > $planetsPagination->lastPage())
        {
            return $planetsQueryBuilder->paginate(10, page: $planetsPagination->lastPage());
        }

        return $planetsPagination;
    }
}
