<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * This class represents the response data for the planets API endpoint.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class PlanetsResponseData extends Data
{
    /**
     * Constructor.
     *
     * @param string|null $next
     * @param string|null $previous
     * @param DataCollection<string, PlanetData> $results
     */
    public function __construct(
        public ?string $next,
        public ?string $previous,
        #[DataCollectionOf(PlanetData::class)]
        public DataCollection $results
    )
    {}
}
