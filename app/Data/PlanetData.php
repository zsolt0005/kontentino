<?php

namespace App\Data;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Represents planet data.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class PlanetData extends DataTransferObject
{
	public string $name;

    #[MapFrom('rotation_period')]
	public string $rotationPeriod;

    #[MapFrom('orbital_period')]
	public string $orbitalPeriod;

	public string $diameter;

	public string $climate;

	public string $gravity;

	public string $terrain;

    #[MapFrom('surface_water')]
	public string $surfaceWater;

	public string $population;

    #[MapFrom('created')]
	public string $createdAt;

    #[MapFrom('edited')]
	public string $editedAt;

	public string $url;
}
