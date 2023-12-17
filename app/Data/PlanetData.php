<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

/**
 * Represents planet data.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class PlanetData extends Data
{
	public string $name;

    #[MapName('rotation_period')]
	public string $rotationPeriod;

    #[MapName('orbital_period')]
	public string $orbitalPeriod;

	public string $diameter;

	public string $climate;

	public string $gravity;

	public string $terrain;

    #[MapName('surface_water')]
	public string $surfaceWater;

	public string $population;

    #[MapName('created')]
	public string $createdAt;

    #[MapName('edited')]
	public string $editedAt;

	public string $url;
}
