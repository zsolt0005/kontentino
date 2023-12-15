<?php

namespace App\Data;

use App\Data\Casters\PlanetDataCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * This class represents the response data for the planets API endpoint.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class PlanetsResponseData extends DataTransferObject
{
	public ?string $next;

	public ?string $previous;

    #[CastWith(PlanetDataCaster::class)]
    /** @var array<PlanetData> $results */
    public array $results;
}
