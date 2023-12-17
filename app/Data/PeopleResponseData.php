<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * This class represents the response data for the people API endpoint.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class PeopleResponseData extends Data
{
    /**
     * Constructor.
     *
     * @param string|null $next
     * @param string|null $previous
     * @param DataCollection<string, PersonData> $results
     */
    public function __construct(
        public ?string $next,
        public ?string $previous,
        #[DataCollectionOf(PersonData::class)]
        public DataCollection $results
    )
    {}
}
