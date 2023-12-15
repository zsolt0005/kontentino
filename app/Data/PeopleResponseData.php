<?php

namespace App\Data;

use App\Data\Casters\PersonDataCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * This class represents the response data for the people API endpoint.
 *
 * @package App\Data
 * @author  Zsolt Döme
 * @since   2023
 */
final class PeopleResponseData extends DataTransferObject
{
	public ?string $next;

	public ?string $previous;

    #[CastWith(PersonDataCaster::class)]
	/** @var array<PersonData> $results */
	public array $results;
}
